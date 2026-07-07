<?php

namespace App\Livewire\Contract;

use App\Models\SubContract;
use App\Models\MainContract;
use App\Models\Vendor;
use App\Models\DataDictionary;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use App\Services\AuditLogService;

#[Layout('layouts.app')]
class SubContractList extends Component
{
    use WithPagination;

    #[Url]
    public string $search = '';

    #[Url]
    public string $status = '';

    #[Url]
    public ?int $mainContractId = null;

    public array $availableColumns = [];
    public array $visibleColumns = [];
    public bool $showColumnPicker = false;

    public function mount(): void
    {
        $this->availableColumns = [
            'contract_no' => ['label' => '合同编号', 'default' => true],
            'contract_name' => ['label' => '合同名称', 'default' => true],
            'main_contract' => ['label' => '关联主合同', 'default' => true],
            'vendor' => ['label' => '分包商', 'default' => true],
            'contract_type' => ['label' => '合同类型', 'default' => true],
            'sub_amount' => ['label' => '分包金额', 'default' => true],
            'signed_date' => ['label' => '签订日期', 'default' => false],
            'start_date' => ['label' => '生效日期', 'default' => true],
            'end_date' => ['label' => '到期日期', 'default' => true],
            'sla_level' => ['label' => 'SLA等级', 'default' => false],
            'status' => ['label' => '合同状态', 'default' => true],
            'service_scope' => ['label' => '服务范围', 'default' => false],
            'service_unit' => ['label' => '服务单位', 'default' => true],
            'managers' => ['label' => '项目经理', 'default' => false],
            'personnel' => ['label' => '关联人员', 'default' => false],
            'created_at' => ['label' => '创建时间', 'default' => false],
        ];

        $saved = session('sub_contract_visible_columns');
        if ($saved) {
            $this->visibleColumns = $saved;
        } else {
            $this->visibleColumns = collect($this->availableColumns)
                ->filter(fn($col) => $col['default'])
                ->keys()
                ->toArray();
        }
    }

    public function updatedVisibleColumns(): void
    {
        session(['sub_contract_visible_columns' => $this->visibleColumns]);
    }

    public function resetFilters(): void
    {
        $this->search = '';
        $this->status = '';
        $this->mainContractId = null;
        $this->resetPage();
    }

    public function deleteContract(int $id): void
    {
        $contract = SubContract::find($id);
        if ($contract) {
            $data = $contract->toArray();
            $contract->delete();
            $this->dispatch('notify', type: 'success', message: '分包合同已删除');
            AuditLogService::delete('contract', '删除分包合同', "删除分包合同：{$data['contract_name']}", $data);
        }
    }

    public function render()
    {
        $query = SubContract::query()->with(['mainContract', 'vendor', 'creator', 'managers.user', 'personnel.user', 'serviceUnit']);

        // Data scope filtering
        $user = auth()->user();
        if (!$user->hasAnyRole(['super_admin', 'admin'])) {
            if ($user->hasRole('project_manager')) {
                // Project manager sees sub-contracts they manage
                $query->whereHas('managers', fn($q) => $q->where('user_id', $user->id));
            } elseif ($user->hasAnyRole(['vendor_admin', 'vendor_staff'])) {
                // Vendor users see sub-contracts for their vendor
                $query->where('vendor_id', $user->vendor_id);
            } elseif ($user->hasRole('viewer')) {
                // viewer sees all
            } elseif ($user->hasRole('service_unit')) {
                // service unit sees sub-contracts for their service unit
                $query->where('service_unit_id', $user->service_unit_id);
            }
        }

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('contract_no', 'like', "%{$this->search}%")
                  ->orWhere('contract_name', 'like', "%{$this->search}%");
            });
        }

        if ($this->status) {
            $query->where('status', $this->status);
        }

        if ($this->mainContractId) {
            $query->where('main_contract_id', $this->mainContractId);
        }

        $contracts = $query->latest()->paginate(15);
        $statusOptions = DataDictionary::where('category', 'contract_status')->pluck('name', 'code');
        $mainContracts = MainContract::select('id', 'contract_name')->get();
        $serviceUnits = \App\Models\ServiceUnit::orderBy('name')->get();

        return view('livewire.contract.sub-contract-list', [
            'contracts' => $contracts,
            'statusOptions' => $statusOptions,
            'mainContracts' => $mainContracts,
            'serviceUnits' => $serviceUnits,
        ]);
    }
}
