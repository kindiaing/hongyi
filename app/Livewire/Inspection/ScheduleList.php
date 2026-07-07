<?php

namespace App\Livewire\Inspection;

use App\Models\Schedule;
use App\Models\Software;
use App\Models\Personnel;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Services\AuditLogService;

#[Layout('layouts.app')]
class ScheduleList extends Component
{
    use WithPagination;

    #[Url] public string $search = '';
    #[Url] public string $shiftType = '';
    #[Url] public ?int $softwareId = null;
    #[Url] public ?int $personnelId = null;
    #[Url] public string $dateFrom = '';
    #[Url] public string $dateTo = '';

    public array $availableColumns = [];
    public array $visibleColumns = [];
    public bool $showColumnPicker = false;

    public function mount(): void
    {
        $this->availableColumns = [
            'software' => ['label' => '软件系统', 'default' => true],
            'personnel' => ['label' => '值班人员', 'default' => true],
            'shift_date' => ['label' => '值班日期', 'default' => true],
            'shift_type' => ['label' => '班次', 'default' => true],
            'start_time' => ['label' => '开始时间', 'default' => true],
            'end_time' => ['label' => '结束时间', 'default' => true],
            'is_replaced' => ['label' => '是否替班', 'default' => false],
            'replaced_by' => ['label' => '替班人', 'default' => false],
            'replace_reason' => ['label' => '替班原因', 'default' => false],
            'status' => ['label' => '状态', 'default' => true],
            'created_at' => ['label' => '创建时间', 'default' => false],
        ];
        $saved = session('schedule_visible_columns');
        $this->visibleColumns = $saved ?: collect($this->availableColumns)->filter(fn($c) => $c['default'])->keys()->toArray();
    }

    public function updatedVisibleColumns(): void
    {
        session(['schedule_visible_columns' => $this->visibleColumns]);
    }

    public function resetFilters(): void
    {
        $this->search = '';
        $this->shiftType = '';
        $this->softwareId = null;
        $this->personnelId = null;
        $this->dateFrom = '';
        $this->dateTo = '';
        $this->resetPage();
    }

    public function deleteSchedule(int $id): void
    {
        $s = Schedule::find($id);
        if ($s) {
            $data = $s->toArray();
            $s->delete();
            $this->dispatch('notify', type: 'success', message: '排班已删除');
            AuditLogService::delete('schedule', '删除排班', "删除排班：ID {$data['id']}", $data);
        }
    }

    public function render()
    {
        $q = Schedule::query()->with(['software', 'personnel', 'replacedByPersonnel']);
        if ($this->search) {
            $q->whereHas('personnel', fn($qq) => $qq->where('name', 'like', "%{$this->search}%"));
        }
        if ($this->shiftType) $q->where('shift_type', $this->shiftType);
        if ($this->softwareId) $q->where('software_id', $this->softwareId);
        if ($this->personnelId) $q->where('personnel_id', $this->personnelId);
        if ($this->dateFrom) $q->whereDate('shift_date', '>=', $this->dateFrom);
        if ($this->dateTo) $q->whereDate('shift_date', '<=', $this->dateTo);

        return view('livewire.inspection.schedule-list', [
            'schedules' => $q->latest('shift_date')->paginate(15),
            'softwareList' => Software::where('status', 1)->select('id', 'software_name')->get(),
            'personnelList' => Personnel::where('status', 1)->select('id', 'name')->get(),
        ]);
    }
}
