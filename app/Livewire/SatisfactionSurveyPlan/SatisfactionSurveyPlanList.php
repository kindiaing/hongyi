<?php

namespace App\Livewire\SatisfactionSurveyPlan;

use App\Models\SatisfactionSurveyPlan;
use App\Models\ServiceUnit;
use App\Models\Vendor;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use App\Services\AuditLogService;

#[Layout('layouts.app')]
class SatisfactionSurveyPlanList extends Component
{
    use WithPagination;

    #[Url] public string $search = '';
    #[Url] public string $serviceUnitId = '';
    #[Url] public string $cycleType = '';
    #[Url] public string $isEnabled = '';

    public array $availableColumns = [];
    public array $visibleColumns = [];
    public bool $showColumnPicker = false;

    public function mount(): void
    {
        $this->availableColumns = [
            'plan_name' => ['label' => '计划名称', 'default' => true],
            'service_unit_name' => ['label' => '服务单位', 'default' => true],
            'vendor_name' => ['label' => '运维单位', 'default' => false],
            'cycle_type' => ['label' => '周期类型', 'default' => true],
            'cycle_month' => ['label' => '执行月份', 'default' => false],
            'cycle_day' => ['label' => '执行日期', 'default' => false],
            'start_date' => ['label' => '开始日期', 'default' => false],
            'end_date' => ['label' => '结束日期', 'default' => false],
            'remind_days' => ['label' => '提前提醒(天)', 'default' => false],
            'is_enabled' => ['label' => '启用状态', 'default' => true],
            'next_execute_at' => ['label' => '下次执行', 'default' => true],
            'created_at' => ['label' => '创建时间', 'default' => false],
        ];
        $saved = session('survey_plan_visible_columns');
        $this->visibleColumns = $saved ?: collect($this->availableColumns)->filter(fn($c) => $c['default'])->keys()->toArray();
    }

    public function updatedVisibleColumns(): void
    {
        session(['survey_plan_visible_columns' => $this->visibleColumns]);
    }

    public function resetFilters(): void
    {
        $this->search = '';
        $this->serviceUnitId = '';
        $this->cycleType = '';
        $this->isEnabled = '';
        $this->resetPage();
    }

    public function toggleEnabled(int $id): void
    {
        $plan = SatisfactionSurveyPlan::find($id);
        if ($plan) {
            $oldData = $plan->toArray();
            $plan->update(['is_enabled' => !$plan->is_enabled]);
            $this->dispatch('notify', type: 'success', message: '计划状态已切换');
            AuditLogService::update('satisfaction_plan', '切换回访计划状态', "切换回访计划状态：{$plan->plan_name}", $oldData, $plan->toArray());
        }
    }

    public function deletePlan(int $id): void
    {
        $plan = SatisfactionSurveyPlan::find($id);
        if ($plan) {
            $data = $plan->toArray();
            $plan->delete();
            $this->dispatch('notify', type: 'success', message: '回访计划已删除');
            AuditLogService::delete('satisfaction_plan', '删除回访计划', "删除回访计划：{$data['plan_name']}", $data);
        }
    }

    public function render()
    {
        $q = SatisfactionSurveyPlan::query()->with(['serviceUnit', 'vendor']);

        // Data scope filtering
        $user = auth()->user();
        if (!$user->hasAnyRole(['super_admin', 'admin'])) {
            if ($user->hasRole('project_manager')) {
                $q->whereRaw('1=0');
            } elseif ($user->hasRole('vendor_admin')) {
                // vendor_admin sees all satisfaction survey plans
            } elseif ($user->hasRole('vendor_staff')) {
                $q->whereRaw('1=0');
            } elseif ($user->hasRole('service_unit')) {
                $q->where('service_unit_id', $user->service_unit_id);
            } elseif ($user->hasRole('viewer')) {
                // viewer sees all, no filter needed
            }
        }

        if ($this->search) {
            $q->where('plan_name', 'like', "%{$this->search}%");
        }
        if ($this->serviceUnitId) {
            $q->where('service_unit_id', (int)$this->serviceUnitId);
        }
        if ($this->cycleType) {
            $q->where('cycle_type', $this->cycleType);
        }
        if ($this->isEnabled !== '') {
            $q->where('is_enabled', (int)$this->isEnabled);
        }

        return view('livewire.satisfaction-survey-plan.satisfaction-survey-plan-list', [
            'plans' => $q->latest()->paginate(15),
            'serviceUnits' => ServiceUnit::where('status', 1)->orderBy('name')->get(),
        ]);
    }
}
