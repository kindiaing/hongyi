<?php

namespace App\Livewire\Contract;

use App\Models\MainContract;
use App\Models\DataDictionary;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use App\Services\AuditLogService;

#[Layout('layouts.app')]
class MainContractList extends Component
{
    use WithPagination;

    #[Url]
    public string $search = '';

    #[Url]
    public string $status = '';

    #[Url]
    public string $dateFrom = '';

    #[Url]
    public string $dateTo = '';

    // 可筛选的列配置
    public array $availableColumns = [];
    public array $visibleColumns = [];
    public bool $showColumnPicker = false;

    public function mount(): void
    {
        $this->availableColumns = [
            'contract_no' => ['label' => '合同编号', 'default' => true],
            'contract_name' => ['label' => '合同名称', 'default' => true],
            'party_a_name' => ['label' => '甲方名称', 'default' => true],
            'party_a_contact' => ['label' => '甲方联系人', 'default' => false],
            'party_a_phone' => ['label' => '甲方电话', 'default' => false],
            'party_b_name' => ['label' => '乙方名称', 'default' => true],
            'total_amount' => ['label' => '合同金额', 'default' => true],
            'signed_date' => ['label' => '签订日期', 'default' => true],
            'start_date' => ['label' => '生效日期', 'default' => true],
            'end_date' => ['label' => '到期日期', 'default' => true],
            'status' => ['label' => '合同状态', 'default' => true],
            'service_scope' => ['label' => '服务范围', 'default' => false],
            'managers' => ['label' => '项目经理', 'default' => false],
            'created_at' => ['label' => '创建时间', 'default' => false],
        ];

        // 从session读取或取默认值
        $saved = session('main_contract_visible_columns');
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
        session(['main_contract_visible_columns' => $this->visibleColumns]);
    }

    public function resetFilters(): void
    {
        $this->search = '';
        $this->status = '';
        $this->dateFrom = '';
        $this->dateTo = '';
        $this->resetPage();
    }

    public function deleteContract(int $id): void
    {
        $contract = MainContract::find($id);
        if ($contract) {
            $data = $contract->toArray();
            $contract->delete();
            $this->dispatch('notify', type: 'success', message: '合同已删除');
            AuditLogService::delete('contract', '删除合同', "删除合同：{$data['contract_name']}", $data);
        }
    }

    public function render()
    {
        $query = MainContract::query()->with('managers.user');

        // Data scope filtering
        $user = auth()->user();
        if (!$user->hasAnyRole(['super_admin', 'admin'])) {
            if ($user->hasRole('project_manager')) {
                // Project manager only sees their own contracts
                $query->whereHas('managers', fn($q) => $q->where('user_id', $user->id));
            } elseif ($user->hasAnyRole(['vendor_admin', 'vendor_staff'])) {
                // Vendor users see contracts where their vendor is party_b or in sub-contracts
                // For main contracts, we check if their vendor is party_b
                $query->where('party_b_name', 'like', '%' . ($user->vendor?->name ?? '') . '%');
            } elseif ($user->hasRole('viewer')) {
                // viewer sees all but read-only
            } elseif ($user->hasRole('service_unit')) {
                // service unit doesn't see main contracts directly
                $query->whereRaw('1=0');
            }
        }

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('contract_no', 'like', "%{$this->search}%")
                  ->orWhere('contract_name', 'like', "%{$this->search}%")
                  ->orWhere('party_a_name', 'like', "%{$this->search}%")
                  ->orWhere('party_b_name', 'like', "%{$this->search}%");
            });
        }

        if ($this->status) {
            $query->where('status', $this->status);
        }

        if ($this->dateFrom) {
            $query->whereDate('start_date', '>=', $this->dateFrom);
        }

        if ($this->dateTo) {
            $query->whereDate('end_date', '<=', $this->dateTo);
        }

        $contracts = $query->with('creator')->latest()->paginate(15);
        $statusOptions = DataDictionary::where('category', 'contract_status')->pluck('name', 'code');

        return view('livewire.contract.main-contract-list', [
            'contracts' => $contracts,
            'statusOptions' => $statusOptions,
        ]);
    }
}
