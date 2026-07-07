<?php

namespace App\Livewire\Inspection;

use App\Models\InspectionTask;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class InspectionTaskDetail extends Component
{
    public int $taskId;
    public InspectionTask $task;

    public function mount(int $id): void
    {
        $this->taskId = $id;
        $this->task = InspectionTask::with(['vendor', 'assignee', 'auditor', 'template.items', 'taskItems.templateItem', 'photos'])->findOrFail($id);
    }

    public function auditTask(bool $pass): void
    {
        $this->task->update([
            'status' => 3,
            'auditor_id' => auth()->id(),
            'audit_time' => now(),
            'audit_result' => $pass ? 1 : 0,
        ]);
        $this->dispatch('notify', type: 'success', message: $pass ? '审核已通过' : '审核未通过');
    }

    public function render()
    {
        return view('livewire.inspection.inspection-task-detail');
    }
}
