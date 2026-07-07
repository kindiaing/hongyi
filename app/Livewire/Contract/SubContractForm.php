<?php

namespace App\Livewire\Contract;

use App\Models\SubContract;
use App\Models\ContractAttachment;
use App\Models\MainContract;
use App\Models\Vendor;
use App\Models\DataDictionary;
use App\Models\User;
use App\Models\SubContractManager;
use App\Models\SubContractPersonnel;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Services\AuditLogService;

#[Layout('layouts.app')]
class SubContractForm extends Component
{
    use WithFileUploads;

    public ?int $contractId = null;
    public array $form = [];
    public array $selectedManagers = [];
    public array $selectedPersonnel = [];
    public bool $isEditing = false;

    #[Validate(['nullable', 'file', 'mimes:doc,docx', 'max:10240'])]
    public $wordFile = null;

    #[Validate(['nullable', 'file', 'mimes:pdf', 'max:10240'])]
    public $pdfFile = null;

    protected function rules(): array
    {
        return [
            'form.main_contract_id' => 'required|exists:main_contracts,id',
            'form.contract_no' => 'required|string|max:100|unique:sub_contracts,contract_no,' . $this->contractId,
            'form.contract_name' => 'required|string|max:255',
            'form.vendor_id' => 'required|exists:vendors,id',
            'form.contract_type' => 'required|string|max:50',
            'form.sub_amount' => 'required|numeric|min:0',
            'form.signed_date' => 'nullable|date',
            'form.start_date' => 'required|date',
            'form.end_date' => 'required|date|after_or_equal:start_date',
            'form.service_scope' => 'nullable|string',
            'form.sla_level' => 'nullable|string|max:50',
            'form.payment_terms' => 'nullable|string',
            'form.status' => 'required|string|max:50',
            'form.remark' => 'nullable|string',
            'form.attachment_visible' => 'nullable|boolean',
            'selectedManagers' => 'nullable|array',
            'selectedPersonnel' => 'nullable|array',
        ];
    }

    public function mount(?int $id = null): void
    {
        if ($id) {
            $this->contractId = $id;
            $this->isEditing = true;
            $contract = SubContract::findOrFail($id);
            $this->form = $contract->toArray();
            $this->selectedManagers = $contract->managers->pluck('user_id')->toArray();
            $this->selectedPersonnel = $contract->personnel->pluck('user_id')->toArray();
        } else {
            $this->form = [
                'contract_no' => 'SC-' . date('Y') . '-' . strtoupper(substr(uniqid(), -6)),
                'status' => 'draft',
                'sub_amount' => 0,
                'attachment_visible' => true,
            ];
            $this->selectedManagers = [];
            $this->selectedPersonnel = [];
        }
    }

    public function save(): void
    {
        $this->validate();

        $data = $this->form;
        $data['created_by'] = Auth::id();

        if ($this->isEditing) {
            $contract = SubContract::findOrFail($this->contractId);
            $oldData = $contract->toArray();
            $contract->update($data);
            $this->syncManagers($contract);
            $this->syncPersonnel($contract);
            $this->processAttachments($contract->id);
            $this->dispatch('notify', type: 'success', message: '分包合同已更新');
            AuditLogService::update('contract', '编辑分包合同', "编辑分包合同：{$contract->contract_name}", $oldData, $contract->toArray());
        } else {
            $contract = SubContract::create($data);
            $this->syncManagers($contract);
            $this->syncPersonnel($contract);
            $this->processAttachments($contract->id);
            $this->dispatch('notify', type: 'success', message: '分包合同已创建');
            AuditLogService::create('contract', '创建分包合同', "创建分包合同：{$contract->contract_name}", $contract->toArray());
        }

        $this->redirect(route('contracts.sub.index'), navigate: true);
    }

    private function syncManagers(SubContract $contract): void
    {
        $contract->managers()->delete();
        foreach ($this->selectedManagers as $userId) {
            if ($userId) {
                SubContractManager::create([
                    'sub_contract_id' => $contract->id,
                    'user_id' => $userId,
                ]);
            }
        }
    }

    private function syncPersonnel(SubContract $contract): void
    {
        $contract->personnel()->delete();
        foreach ($this->selectedPersonnel as $userId) {
            if ($userId) {
                SubContractPersonnel::create([
                    'sub_contract_id' => $contract->id,
                    'user_id' => $userId,
                ]);
            }
        }
    }

    private function processAttachments(int $contractId): void
    {
        $uploadDir = 'contracts/' . date('Y/m');

        if ($this->wordFile) {
            $path = $this->wordFile->store($uploadDir, 'public');
            ContractAttachment::create([
                'contract_type' => 'sub',
                'contract_id' => $contractId,
                'file_name' => $this->wordFile->getClientOriginalName(),
                'file_path' => $path,
                'file_size' => $this->wordFile->getSize(),
                'file_type' => $this->wordFile->getMimeType(),
                'version_type' => 'word',
                'is_sealed' => false,
                'uploaded_by' => Auth::id(),
            ]);
            $this->wordFile = null;
        }

        if ($this->pdfFile) {
            $path = $this->pdfFile->store($uploadDir, 'public');
            ContractAttachment::create([
                'contract_type' => 'sub',
                'contract_id' => $contractId,
                'file_name' => $this->pdfFile->getClientOriginalName(),
                'file_path' => $path,
                'file_size' => $this->pdfFile->getSize(),
                'file_type' => $this->pdfFile->getMimeType(),
                'version_type' => 'pdf_sealed',
                'is_sealed' => true,
                'uploaded_by' => Auth::id(),
            ]);
            $this->pdfFile = null;
        }
    }

    public function deleteAttachment(int $attachmentId): void
    {
        $att = ContractAttachment::find($attachmentId);
        if ($att) {
            Storage::disk('public')->delete($att->file_path);
            $att->delete();
            $this->dispatch('notify', type: 'success', message: '附件已删除');
        }
    }

    public function render()
    {
        $statusOptions = DataDictionary::where('category', 'contract_status')->pluck('name', 'code');
        $contractTypeOptions = DataDictionary::where('category', 'contract_type')->pluck('name', 'code');
        $mainContracts = MainContract::select('id', 'contract_name')->get();
        $vendors = Vendor::select('id', 'name')->where('cooperation_status', 1)->get();

        $attachments = $this->isEditing
            ? ContractAttachment::where('contract_type', 'sub')
                ->where('contract_id', $this->contractId)
                ->latest()
                ->get()
            : collect();

        // Available users for assignment
        $projectManagers = User::role('project_manager')->where('status', 1)->get();
        $availablePersonnel = User::where('status', 1)
            ->where(function($q) {
                $q->whereHas('roles', fn($r) => $r->whereIn('name', ['project_manager', 'vendor_staff']))
                  ->orWhereDoesntHave('roles');
            })
            ->get();

        return view('livewire.contract.sub-contract-form', [
            'statusOptions' => $statusOptions,
            'contractTypeOptions' => $contractTypeOptions,
            'mainContracts' => $mainContracts,
            'vendors' => $vendors,
            'attachments' => $attachments,
            'projectManagers' => $projectManagers,
            'availablePersonnel' => $availablePersonnel,
        ]);
    }
}
