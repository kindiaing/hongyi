<?php

namespace App\Livewire\Contract;

use App\Models\MainContract;
use App\Models\ContractAttachment;
use App\Models\DataDictionary;
use App\Models\User;
use App\Models\MainContractManager;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Services\AuditLogService;

#[Layout('layouts.app')]
class MainContractForm extends Component
{
    use WithFileUploads;

    public ?int $contractId = null;
    public array $form = [];
    public array $selectedManagers = [];
    public bool $isEditing = false;

    #[Validate(['nullable', 'file', 'mimes:doc,docx', 'max:10240'])]
    public $wordFile = null;

    #[Validate(['nullable', 'file', 'mimes:pdf', 'max:10240'])]
    public $pdfFile = null;

    protected function rules(): array
    {
        return [
            'form.contract_no' => 'required|string|max:100|unique:main_contracts,contract_no,' . $this->contractId,
            'form.contract_name' => 'required|string|max:255',
            'form.party_a_name' => 'required|string|max:255',
            'form.party_a_contact' => 'nullable|string|max:100',
            'form.party_a_phone' => 'nullable|string|max:20',
            'form.party_b_name' => 'required|string|max:255',
            'form.party_b_manager_name' => 'nullable|string|max:100',
            'form.party_b_manager_phone' => 'nullable|string|max:20',
            'form.service_unit_id' => 'nullable|integer|exists:service_units,id',
            'form.total_amount' => 'required|numeric|min:0',
            'form.signed_date' => 'nullable|date',
            'form.start_date' => 'required|date',
            'form.end_date' => 'required|date|after_or_equal:start_date',
            'form.payment_terms' => 'nullable|string',
            'form.service_scope' => 'nullable|string',
            'form.status' => 'required|string|max:50',
            'form.remark' => 'nullable|string',
            'form.attachment_visible' => 'nullable|boolean',
            'selectedManagers' => 'nullable|array',
        ];
    }

    public function mount(?int $id = null): void
    {
        if ($id) {
            $this->contractId = $id;
            $this->isEditing = true;
            $contract = MainContract::findOrFail($id);
            $this->form = $contract->toArray();
            $this->selectedManagers = $contract->managers->pluck('user_id')->toArray();
        } else {
            $this->form = [
                'contract_no' => 'MC-' . date('Y') . '-' . strtoupper(substr(uniqid(), -6)),
                'status' => 'draft',
                'total_amount' => 0,
                'attachment_visible' => true,
            ];
            $this->selectedManagers = [];
        }
    }

    public function save(): void
    {
        $this->validate();

        $data = $this->form;
        $data['created_by'] = Auth::id();

        if ($this->isEditing) {
            $contract = MainContract::findOrFail($this->contractId);
            $oldData = $contract->toArray();
            $contract->update($data);
            $this->syncManagers($contract);
            $this->processAttachments($contract->id);
            $this->dispatch('notify', type: 'success', message: '合同已更新');
            AuditLogService::update('contract', '编辑合同', "编辑合同：{$contract->contract_name}", $oldData, $contract->toArray());
        } else {
            $contract = MainContract::create($data);
            $this->syncManagers($contract);
            $this->processAttachments($contract->id);
            $this->dispatch('notify', type: 'success', message: '合同已创建');
            AuditLogService::create('contract', '创建合同', "创建合同：{$contract->contract_name}", $contract->toArray());
        }

        $this->redirect(route('contracts.main.index'), navigate: true);
    }

    private function syncManagers(MainContract $contract): void
    {
        $contract->managers()->delete();
        foreach ($this->selectedManagers as $userId) {
            if ($userId) {
                MainContractManager::create([
                    'main_contract_id' => $contract->id,
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
                'contract_type' => 'main',
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
                'contract_type' => 'main',
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

    public function toggleAttachmentVisible(): void
    {
        if (!$this->isEditing) return;
        $contract = MainContract::find($this->contractId);
        if ($contract) {
            $contract->attachment_visible = !$contract->attachment_visible;
            $contract->save();
            $this->form['attachment_visible'] = $contract->attachment_visible;
        }
    }

    public function render()
    {
        $statusOptions = DataDictionary::where('category', 'contract_status')->pluck('name', 'code');
        $attachments = $this->isEditing
            ? ContractAttachment::where('contract_type', 'main')
                ->where('contract_id', $this->contractId)
                ->latest()
                ->get()
            : collect();

        // Available project managers: users with project_manager role
        $projectManagers = User::role('project_manager')->where('status', 1)->get();
        $serviceUnits = \App\Models\ServiceUnit::orderBy('name')->get();

        return view('livewire.contract.main-contract-form', [
            'statusOptions' => $statusOptions,
            'attachments' => $attachments,
            'projectManagers' => $projectManagers,
            'serviceUnits' => $serviceUnits,
        ]);
    }
}
