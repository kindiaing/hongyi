<?php

namespace App\Livewire\SatisfactionSurveyPlan;

use App\Models\SatisfactionSurveyPlan;
use App\Models\ServiceUnit;
use App\Models\Vendor;
use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Services\AuditLogService;

#[Layout('layouts.app')]
class SatisfactionSurveyPlanForm extends Component
{
    public ?int $planId = null;
    public array $form = [];
    public bool $isEditing = false;

    protected function rules(): array
    {
        return [
            'form.plan_name' => 'required|string|max:255',
            'form.service_unit_id' => 'required|exists:service_units,id',
            'form.vendor_id' => 'nullable|exists:vendors,id',
            'form.cycle_type' => 'required|in:monthly,quarterly,annually,custom',
            'form.cycle_month' => 'nullable|integer|min:1|max:12',
            'form.cycle_day' => 'nullable|integer|min:1|max:31',
            'form.start_date' => 'required|date',
            'form.end_date' => 'nullable|date|after_or_equal:form.start_date',
            'form.remind_days' => 'required|integer|min:0|max:30',
            'form.is_enabled' => 'required|boolean',
            'form.remark' => 'nullable|string',
        ];
    }

    public function mount(?int $id = null): void
    {
        if ($id) {
            $this->planId = $id;
            $this->isEditing = true;
            $this->form = SatisfactionSurveyPlan::findOrFail($id)->toArray();
        } else {
            $this->form = [
                'start_date' => now()->toDateString(),
                'is_enabled' => true,
                'remind_days' => 3,
                'cycle_type' => 'monthly',
            ];
        }
    }

    public function updatedFormCycleType(): void
    {
        // Reset month/day when cycle type changes
        if (!in_array($this->form['cycle_type'] ?? '', ['quarterly', 'annually'])) {
            $this->form['cycle_month'] = null;
        }
        if (($this->form['cycle_type'] ?? '') === 'custom') {
            $this->form['cycle_day'] = null;
        }
    }

    public function save(): void
    {
        $this->validate();

        // Calculate next_execute_at based on cycle
        $this->form['next_execute_at'] = $this->calculateNextExecuteAt();

        if ($this->isEditing) {
            $plan = SatisfactionSurveyPlan::findOrFail($this->planId);
            $oldData = $plan->toArray();
            $plan->update($this->form);
            $this->dispatch('notify', type: 'success', message: '回访计划已更新');
            AuditLogService::update('satisfaction_plan', '编辑回访计划', "编辑回访计划：{$plan->plan_name}", $oldData, $plan->toArray());
        } else {
            $plan = SatisfactionSurveyPlan::create($this->form);
            $this->dispatch('notify', type: 'success', message: '回访计划已创建');
            AuditLogService::create('satisfaction_plan', '创建回访计划', "创建回访计划：{$plan->plan_name}", $plan->toArray());
        }
        $this->redirect(route('satisfaction-survey-plans.index'), navigate: true);
    }

    private function calculateNextExecuteAt(): ?string
    {
        $startDate = isset($this->form['start_date']) ? \Carbon\Carbon::parse($this->form['start_date']) : now();
        $cycleType = $this->form['cycle_type'] ?? 'monthly';
        $cycleMonth = $this->form['cycle_month'] ?? null;
        $cycleDay = $this->form['cycle_day'] ?? null;

        $next = $startDate->copy();

        switch ($cycleType) {
            case 'monthly':
                $day = $cycleDay ?? 1;
                $next = $next->day(min($day, $next->daysInMonth));
                if ($next->isPast()) {
                    $next = $next->addMonth();
                }
                break;
            case 'quarterly':
                $month = $cycleMonth ?? 1;
                $day = $cycleDay ?? 1;
                $next = $next->month($month)->day(min($day, $next->daysInMonth));
                while ($next->isPast()) {
                    $next = $next->addMonths(3);
                }
                break;
            case 'annually':
                $month = $cycleMonth ?? 1;
                $day = $cycleDay ?? 1;
                $next = $next->month($month)->day(min($day, $next->daysInMonth));
                if ($next->isPast()) {
                    $next = $next->addYear();
                }
                break;
            case 'custom':
                $next = $startDate;
                break;
        }

        return $next->startOfDay()->toDateTimeString();
    }

    public function render()
    {
        return view('livewire.satisfaction-survey-plan.satisfaction-survey-plan-form', [
            'serviceUnits' => ServiceUnit::where('status', 1)->orderBy('name')->get(),
            'vendors' => Vendor::where('cooperation_status', 1)->orderBy('name')->get(),
        ]);
    }
}
