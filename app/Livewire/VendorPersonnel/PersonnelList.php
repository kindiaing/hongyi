<?php

namespace App\Livewire\VendorPersonnel;

use App\Models\Personnel;
use App\Models\Vendor;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use App\Services\AuditLogService;

#[Layout('layouts.app')]
class PersonnelList extends Component
{
    use WithPagination;

    #[Url] public string $search = '';
    #[Url] public string $status = '';
    #[Url] public ?int $vendorId = null;

    public array $availableColumns = [];
    public array $visibleColumns = [];
    public bool $showColumnPicker = false;

    public function mount(): void
    {
        $this->availableColumns = [
            'name' => ['label' => '姓名', 'default' => true],
            'vendor' => ['label' => '所属单位', 'default' => true],
            'phone' => ['label' => '手机号', 'default' => true],
            'email' => ['label' => '邮箱', 'default' => false],
            'gender' => ['label' => '性别', 'default' => false],
            'position' => ['label' => '岗位', 'default' => true],
            'job_title' => ['label' => '职称', 'default' => false],
            'entry_date' => ['label' => '入职日期', 'default' => false],
            'status' => ['label' => '在职状态', 'default' => true],
            'is_resident' => ['label' => '是否驻场', 'default' => false],
            'resident_location' => ['label' => '驻场地点', 'default' => false],
            'work_start_time' => ['label' => '工作开始', 'default' => false],
            'work_end_time' => ['label' => '工作结束', 'default' => false],
            'emergency_contact' => ['label' => '紧急联系人', 'default' => false],
            'emergency_phone' => ['label' => '紧急电话', 'default' => false],
            'created_at' => ['label' => '创建时间', 'default' => false],
        ];
        $saved = session('personnel_visible_columns');
        $this->visibleColumns = $saved ?: collect($this->availableColumns)->filter(fn($c) => $c['default'])->keys()->toArray();
    }

    public function updatedVisibleColumns(): void { session(['personnel_visible_columns' => $this->visibleColumns]); }

    public function resetFilters(): void
    {
        $this->search = ''; $this->status = ''; $this->vendorId = null; $this->resetPage();
    }

    public function deletePersonnel(int $id): void
    {
        $p = Personnel::find($id);
        if ($p) {
            $data = $p->toArray();
            $p->delete();
            $this->dispatch('notify', type: 'success', message: '人员已删除');
            AuditLogService::delete('personnel', '删除运维人员', "删除运维人员：{$data['name']}", $data);
        }
    }

    public function render()
    {
        $q = Personnel::query()->with(['vendor']);
        if ($this->search) {
            $q->where(function ($qq) {
                $qq->where('name', 'like', "%{$this->search}%")
                  ->orWhere('phone', 'like', "%{$this->search}%")
                  ->orWhere('position', 'like', "%{$this->search}%");
            });
        }
        if ($this->status !== '') $q->where('status', (int)$this->status);
        if ($this->vendorId) $q->where('vendor_id', $this->vendorId);

        return view('livewire.vendor-personnel.personnel-list', [
            'personnel' => $q->latest()->paginate(15),
            'vendors' => Vendor::select('id', 'name')->where('cooperation_status', 1)->get(),
        ]);
    }
}
