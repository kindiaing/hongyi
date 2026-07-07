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
use Illuminate\Support\Facades\Auth;
use App\Services\AuditLogService;

#[Layout('layouts.app')]
class InspectionPlanForm extends Component
{
    public ?int $planId = null;
    public array $form = [];
    public bool $isEditing = false;

    protected function rules(): array
    {
        return [
            'form.plan_name' => 'required|string|max:255',
            'form.template_id' => 'required|exists:inspection_templates,id',
            'form.vendor_id' => 'required|exists:vendors,id',
            'form.target_type' => 'required|in:software,hardware',
            'form.target_id' => 'required|integer|min:1',
            'form.cycle_type' => 'required|in:daily,weekly,biweekly,monthly,quarterly,custom',
            'form.cycle_days' => 'nullable|integer|min:1',
            'form.execute_time' => 'required',
            'form.start_date' => 'required|date',
            'form.end_date' => 'nullable|date|after_or_equal:start_date',
            'form.assignee_id' => 'nullable|exists:personnel,id',
            'form.is_enabled' => 'boolean',
        ];
    }

    public function mount(?int $id = null): void
    {
        if ($id) {
            $this->planId = $id;
            $this->isEditing = true;
            $plan = InspectionPlan::findOrFail($id);
            $this->form = $plan->toArray();
            $this->form['execute_time'] = substr($plan->execute_time, 0, 5);
        } else {
            $this->form = [
                'target_type' => 'hardware',
                'cycle_type' => 'weekly',
                'is_enabled' => true,
                'execute_time' => '09:00',
                'start_date' => now()->format('Y-m-d'),
            ];
        }
    }

    public function save(): void
    {
        $this->validate();
        $data = $this->form;
        $data['created_by'] = Auth::id();
        if ($this->isEditing) {
            $plan = InspectionPlan::findOrFail($this->planId);
            $oldData = $plan->toArray();
            $plan->update($data);
            $this->dispatch('notify', type: 'success', message: '计划已更新');
            AuditLogService::update('inspection_plan', '编辑巡检计划', "编辑巡检计划：{$plan->plan_name}", $oldData, $plan->toArray());
        } else {
            $plan = InspectionPlan::create($data);
            $this->dispatch('notify', type: 'success', message: '计划已创建');
            AuditLogService::create('inspection_plan', '创建巡检计划', "创建巡检计划：{$plan->plan_name}", $plan->toArray());
        }
        $this->redirect(route('inspection.plans.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.inspection.inspection-plan-form', [
            'templates' => InspectionTemplate::where('is_enabled', 1)->get(),
            'vendors' => Vendor::select('id', 'name')->where('cooperation_status', 1)->get(),
            'personnel' => Personnel::where('status', 1)->get(),
            'hardwareDevices' => HardwareDevice::where('status', 1)->select('id', 'device_name')->get(),
            'softwareList' => Software::where('status', 1)->select('id', 'software_name')->get(),
        ]);
    }
}
