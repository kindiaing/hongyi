<?php

namespace App\Livewire\Asset;

use App\Models\Software;
use App\Models\Vendor;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use App\Services\AuditLogService;

#[Layout('layouts.app')]
class SoftwareList extends Component
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
            'software_no' => ['label' => '软件编号', 'default' => true],
            'software_name' => ['label' => '软件名称', 'default' => true],
            'version' => ['label' => '版本号', 'default' => true],
            'deploy_environment' => ['label' => '部署环境', 'default' => true],
            'deploy_server' => ['label' => '部署服务器', 'default' => false],
            'license_info' => ['label' => '许可证', 'default' => false],
            'vendor' => ['label' => '运维单位', 'default' => true],
            'maintenance_start_date' => ['label' => '运维开始', 'default' => true],
            'maintenance_end_date' => ['label' => '运维结束', 'default' => true],
            'sla_level' => ['label' => 'SLA等级', 'default' => false],
            'is_resident_required' => ['label' => '需驻场', 'default' => false],
            'work_start_time' => ['label' => '工作开始', 'default' => false],
            'work_end_time' => ['label' => '工作结束', 'default' => false],
            'emergency_response_time' => ['label' => '响应时间(分)', 'default' => false],
            'status' => ['label' => '状态', 'default' => true],
            'created_at' => ['label' => '创建时间', 'default' => false],
        ];
        $saved = session('software_visible_columns');
        $this->visibleColumns = $saved ?: collect($this->availableColumns)->filter(fn($c) => $c['default'])->keys()->toArray();
    }

    public function updatedVisibleColumns(): void { session(['software_visible_columns' => $this->visibleColumns]); }

    public function resetFilters(): void
    {
        $this->search = ''; $this->status = ''; $this->vendorId = null; $this->resetPage();
    }

    public function deleteSoftware(int $id): void
    {
        $s = Software::find($id);
        if ($s) {
            $data = $s->toArray();
            $s->delete();
            $this->dispatch('notify', type: 'success', message: '软件已删除');
            AuditLogService::delete('software', '删除软件系统', "删除软件系统：{$data['software_name']}", $data);
        }
    }

    public function render()
    {
        $q = Software::query()->with(['vendor', 'subContract']);

        // Data scope filtering
        $user = auth()->user();
        if (!$user->hasAnyRole(['super_admin', 'admin'])) {
            if ($user->hasRole('project_manager')) {
                $q->whereHas('subContract', function ($sq) use ($user) {
                    $sq->whereHas('managers', fn($q2) => $q2->where('user_id', $user->id))
                       ->orWhereHas('mainContract.managers', fn($q2) => $q2->where('user_id', $user->id));
                });
            } elseif ($user->hasAnyRole(['vendor_admin', 'vendor_staff'])) {
                $q->whereHas('subContract', fn($sq) => $sq->where('vendor_id', $user->vendor_id));
            } elseif ($user->hasRole('service_unit')) {
                $q->whereRaw('1=0');
            } elseif ($user->hasRole('viewer')) {
                // viewer sees all
            }
        }

        if ($this->search) {
            $q->where(function ($qq) {
                $qq->where('software_no', 'like', "%{$this->search}%")
                  ->orWhere('software_name', 'like', "%{$this->search}%")
                  ->orWhere('version', 'like', "%{$this->search}%")
                  ->orWhere('deploy_server', 'like', "%{$this->search}%");
            });
        }
        if ($this->status !== '') $q->where('status', (int)$this->status);
        if ($this->vendorId) $q->where('vendor_id', $this->vendorId);

        return view('livewire.asset.software-list', [
            'software' => $q->latest()->paginate(15),
            'vendors' => Vendor::select('id', 'name')->where('cooperation_status', 1)->get(),
        ]);
    }
}
