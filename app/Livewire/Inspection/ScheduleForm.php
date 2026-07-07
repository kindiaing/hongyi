<?php

namespace App\Livewire\Inspection;

use App\Models\Schedule;
use App\Models\Software;
use App\Models\Personnel;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use App\Services\AuditLogService;

#[Layout('layouts.app')]
class ScheduleForm extends Component
{
    public ?int $scheduleId = null;
    public array $form = [];
    public bool $isEditing = false;

    protected function rules(): array
    {
        return [
            'form.software_id' => 'nullable|exists:software,id',
            'form.personnel_id' => 'required|exists:personnel,id',
            'form.shift_date' => 'required|date',
            'form.shift_type' => 'required|in:day,night,holiday',
            'form.start_time' => 'required',
            'form.end_time' => 'required',
            'form.is_replaced' => 'boolean',
            'form.replaced_by' => 'nullable|exists:personnel,id',
            'form.replace_reason' => 'nullable|string|max:255',
            'form.status' => 'required|integer|in:0,1',
        ];
    }

    public function mount(?int $id = null): void
    {
        if ($id) {
            $this->scheduleId = $id;
            $this->isEditing = true;
            $s = Schedule::findOrFail($id);
            $this->form = $s->toArray();
            $this->form['start_time'] = substr($s->start_time, 0, 5);
            $this->form['end_time'] = substr($s->end_time, 0, 5);
        } else {
            $this->form = [
                'shift_type' => 'day',
                'start_time' => '08:00',
                'end_time' => '18:00',
                'status' => 1,
                'is_replaced' => false,
                'shift_date' => now()->format('Y-m-d'),
            ];
        }
    }

    public function save(): void
    {
        $this->validate();
        $data = $this->form;
        $data['created_by'] = Auth::id();
        if ($this->isEditing) {
            $schedule = Schedule::findOrFail($this->scheduleId);
            $oldData = $schedule->toArray();
            $schedule->update($data);
            $this->dispatch('notify', type: 'success', message: '排班已更新');
            AuditLogService::update('schedule', '编辑排班', "编辑排班：ID {$schedule->id}", $oldData, $schedule->toArray());
        } else {
            $schedule = Schedule::create($data);
            $this->dispatch('notify', type: 'success', message: '排班已创建');
            AuditLogService::create('schedule', '创建排班', "创建排班：ID {$schedule->id}", $schedule->toArray());
        }
        $this->redirect(route('inspection.schedules.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.inspection.schedule-form', [
            'softwareList' => Software::where('status', 1)->select('id', 'software_name')->get(),
            'personnelList' => Personnel::where('status', 1)->select('id', 'name')->get(),
        ]);
    }
}
