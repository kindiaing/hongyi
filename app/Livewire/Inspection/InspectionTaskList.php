<?php

namespace App\Livewire\Inspection;

use App\Models\InspectionTask;
use App\Models\Vendor;
use App\Models\Personnel;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use App\Services\AuditLogService;

#[Layout('layouts.app')]
class InspectionTaskList extends Component
{
    use WithPagination;

    #[Url] public string $search = '';
    #[Url] public string $taskType = '';
    #[Url] public string $status = '';
    #[Url] public ?int $vendorId = null;
    #[Url] public ?int $assigneeId = null;

    public array $availableColumns = [];
    public array $visibleColumns = [];
    public bool $showColumnPicker = false;

    public function mount(): void
    {
        $this->availableColumns = [
            'task_no' => ['label' => '任务编号', 'default' => true],
            'task_name' => ['label' => '任务名称', 'default' => true],
            'task_type' => ['label' => '任务类型', 'default' => true],
            'vendor' => ['label' => '运维单位', 'default' => true],
            'target' => ['label' => '巡检对象', 'default' => true],
            'assignee' => ['label' => '执行人', 'default' => true],
            'planned_date' => ['label' => '计划日期', 'default' => true],
            'planned_time' => ['label' => '计划时间', 'default' => false],
            'start_time' => ['label' => '开始时间', 'default' => false],
            'end_time' => ['label' => '结束时间', 'default' => false],
            'overall_result' => ['label' => '检查结果', 'default' => true],
            'status' => ['label' => '状态', 'default' => true],
            'auditor' => ['label' => '审核人', 'default' => false],
            'audit_result' => ['label' => '审核结果', 'default' => false],
            'created_at' => ['label' => '创建时间', 'default' => false],
        ];
        $saved = session('inspection_task_visible_columns');
        $this->visibleColumns = $saved ?: collect($this->availableColumns)->filter(fn($c) => $c['default'])->keys()->toArray();
    }

    public function updatedVisibleColumns(): void
    {
        session(['inspection_task_visible_columns' => $this->visibleColumns]);
    }

    public function resetFilters(): void
    {
        $this->search = '';
        $this->taskType = '';
        $this->status = '';
        $this->vendorId = null;
        $this->assigneeId = null;
        $this->resetPage();
    }

    public function deleteTask(int $id): void
    {
        $task = InspectionTask::find($id);
        if ($task) {
            $data = $task->toArray();
            $task->delete();
            $this->dispatch('notify', type: 'success', message: '任务已删除');
            AuditLogService::delete('inspection_task', '删除巡检任务', "删除巡检任务：{$data['task_name']}", $data);
        }
    }

    public function render()
    {
        $q = InspectionTask::query()->with(['vendor', 'assignee', 'auditor', 'template']);

        // Data scope filtering
        $user = auth()->user();
        if (!$user->hasAnyRole(['super_admin', 'admin'])) {
            if ($user->hasRole('project_manager')) {
                $managedSubContractIds = \App\Models\SubContract::whereHas('managers', fn($q) => $q->where('user_id', $user->id))
                    ->orWhereHas('mainContract.managers', fn($q) => $q->where('user_id', $user->id))
                    ->pluck('id');

                if ($managedSubContractIds->isEmpty()) {
                    $q->whereRaw('1=0');
                } else {
                    $q->where(function($qq) use ($managedSubContractIds) {
                        $qq->whereExists(function($sq) use ($managedSubContractIds) {
                            $sq->selectRaw(1)
                                ->from('hardware_devices')
                                ->whereColumn('hardware_devices.id', 'inspection_tasks.target_id')
                                ->where('inspection_tasks.target_type', 'hardware')
                                ->whereIn('hardware_devices.sub_contract_id', $managedSubContractIds);
                        })
                        ->orWhereExists(function($sq) use ($managedSubContractIds) {
                            $sq->selectRaw(1)
                                ->from('software')
                                ->whereColumn('software.id', 'inspection_tasks.target_id')
                                ->where('inspection_tasks.target_type', 'software')
                                ->whereIn('software.sub_contract_id', $managedSubContractIds);
                        });
                    });
                }
            } elseif ($user->hasAnyRole(['vendor_admin', 'vendor_staff'])) {
                $q->where('vendor_id', $user->vendor_id);
            } elseif ($user->hasRole('service_unit')) {
                $q->whereRaw('1=0');
            } elseif ($user->hasRole('viewer')) {
                // viewer sees all, no filter needed
            }
        }

        if ($this->search) {
            $q->where(function ($qq) {
                $qq->where('task_no', 'like', "%{$this->search}%")
                  ->orWhere('task_name', 'like', "%{$this->search}%")
                  ->orWhere('exception_desc', 'like', "%{$this->search}%");
            });
        }
        if ($this->taskType) $q->where('task_type', $this->taskType);
        if ($this->status !== '') $q->where('status', (int)$this->status);
        if ($this->vendorId) $q->where('vendor_id', $this->vendorId);
        if ($this->assigneeId) $q->where('assignee_id', $this->assigneeId);

        return view('livewire.inspection.inspection-task-list', [
            'tasks' => $q->latest()->paginate(15),
            'vendors' => Vendor::select('id', 'name')->where('cooperation_status', 1)->get(),
            'personnel' => Personnel::select('id', 'name')->where('status', 1)->get(),
        ]);
    }
}
