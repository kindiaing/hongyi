<?php

namespace App\Livewire\Inspection;

use App\Models\InspectionPlan;
use App\Models\InspectionTemplate;
use App\Models\Vendor;
use App\Models\Personnel;
use App\Models\HardwareDevice;
use App\Models\Software;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Services\AuditLogService;

#[Layout('layouts.app')]
class InspectionPlanList extends Component
{
    use WithPagination;

    #[Url] public string $search = '';
    #[Url] public string $cycleType = '';
    #[Url] public ?int $vendorId = null;
    #[Url] public ?int $templateId = null;

    public array $availableColumns = [];
    public array $visibleColumns = [];
    public bool $showColumnPicker = false;

    public function mount(): void
    {
        $this->availableColumns = [
            'plan_name' => ['label' => '计划名称', 'default' => true],
            'template' => ['label' => '巡检模板', 'default' => true],
            'vendor' => ['label' => '运维单位', 'default' => true],
            'target' => ['label' => '巡检对象', 'default' => true],
            'cycle_type' => ['label' => '周期', 'default' => true],
            'execute_time' => ['label' => '执行时间', 'default' => false],
            'start_date' => ['label' => '开始日期', 'default' => true],
            'end_date' => ['label' => '结束日期', 'default' => false],
            'assignee' => ['label' => '负责人', 'default' => true],
            'is_enabled' => ['label' => '启用状态', 'default' => true],
            'last_generated_at' => ['label' => '上次生成', 'default' => false],
            'next_generate_at' => ['label' => '下次生成', 'default' => false],
            'created_at' => ['label' => '创建时间', 'default' => false],
        ];
        $saved = session('inspection_plan_visible_columns');
        $this->visibleColumns = $saved ?: collect($this->availableColumns)->filter(fn($c) => $c['default'])->keys()->toArray();
    }

    public function updatedVisibleColumns(): void
    {
        session(['inspection_plan_visible_columns' => $this->visibleColumns]);
    }

    public function resetFilters(): void
    {
        $this->search = '';
        $this->cycleType = '';
        $this->vendorId = null;
        $this->templateId = null;
        $this->resetPage();
    }

    public function toggleEnabled(int $id): void
    {
        $plan = InspectionPlan::find($id);
        if ($plan) {
            $oldData = $plan->toArray();
            $plan->update(['is_enabled' => !$plan->is_enabled]);
            $this->dispatch('notify', type: 'success', message: '状态已更新');
            AuditLogService::update('inspection_plan', '切换巡检计划状态', "切换巡检计划状态：{$plan->plan_name}", $oldData, $plan->toArray());
        }
    }

    public function deletePlan(int $id): void
    {
        $plan = InspectionPlan::find($id);
        if ($plan) {
            $data = $plan->toArray();
            $plan->delete();
            $this->dispatch('notify', type: 'success', message: '计划已删除');
            AuditLogService::delete('inspection_plan', '删除巡检计划', "删除巡检计划：{$data['plan_name']}", $data);
        }
    }

    public function render()
    {
        $q = InspectionPlan::query()->with(['template', 'vendor', 'assignee']);
        if ($this->search) {
            $q->where('plan_name', 'like', "%{$this->search}%");
        }
        if ($this->cycleType) $q->where('cycle_type', $this->cycleType);
        if ($this->vendorId) $q->where('vendor_id', $this->vendorId);
        if ($this->templateId) $q->where('template_id', $this->templateId);

        return view('livewire.inspection.inspection-plan-list', [
            'plans' => $q->latest()->paginate(15),
            'vendors' => Vendor::select('id', 'name')->where('cooperation_status', 1)->get(),
            'templates' => InspectionTemplate::where('is_enabled', 1)->select('id', 'template_name')->get(),
        ]);
    }
}
