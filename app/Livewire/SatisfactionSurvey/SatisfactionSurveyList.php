<?php

namespace App\Livewire\SatisfactionSurvey;

use App\Models\SatisfactionSurvey;
use App\Models\ServiceUnit;
use App\Models\Personnel;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use App\Services\AuditLogService;

#[Layout('layouts.app')]
class SatisfactionSurveyList extends Component
{
    use WithPagination;

    #[Url] public string $search = '';
    #[Url] public string $serviceUnitId = '';
    #[Url] public string $satisfactionLevel = '';
    #[Url] public string $status = '';
    #[Url] public string $dateFrom = '';
    #[Url] public string $dateTo = '';

    public array $availableColumns = [];
    public array $visibleColumns = [];
    public bool $showColumnPicker = false;

    public function mount(): void
    {
        $this->availableColumns = [
            'survey_date' => ['label' => '回访日期', 'default' => true],
            'service_unit_name' => ['label' => '服务单位', 'default' => true],
            'personnel_name' => ['label' => '被评价人员', 'default' => true],
            'satisfaction_level' => ['label' => '满意度', 'default' => true],
            'service_attitude_score' => ['label' => '服务态度', 'default' => false],
            'response_speed_score' => ['label' => '响应速度', 'default' => false],
            'technical_level_score' => ['label' => '技术水平', 'default' => false],
            'average_score' => ['label' => '综合评分', 'default' => true],
            'surveyor_name' => ['label' => '调查人', 'default' => false],
            'status' => ['label' => '状态', 'default' => true],
            'created_at' => ['label' => '创建时间', 'default' => false],
        ];
        $saved = session('satisfaction_survey_visible_columns');
        $this->visibleColumns = $saved ?: collect($this->availableColumns)->filter(fn($c) => $c['default'])->keys()->toArray();
    }

    public function updatedVisibleColumns(): void
    {
        session(['satisfaction_survey_visible_columns' => $this->visibleColumns]);
    }

    public function resetFilters(): void
    {
        $this->search = '';
        $this->serviceUnitId = '';
        $this->satisfactionLevel = '';
        $this->status = '';
        $this->dateFrom = '';
        $this->dateTo = '';
        $this->resetPage();
    }

    public function deleteSurvey(int $id): void
    {
        $survey = SatisfactionSurvey::find($id);
        if ($survey) {
            $data = $survey->toArray();
            $survey->delete();
            $this->dispatch('notify', type: 'success', message: '回访记录已删除');
            AuditLogService::delete('satisfaction', '删除回访记录', "删除回访记录：ID {$data['id']}", $data);
        }
    }

    public function render()
    {
        $q = SatisfactionSurvey::query()->with(['serviceUnit', 'personnel', 'surveyor']);

        // Data scope filtering
        $user = auth()->user();
        if (!$user->hasAnyRole(['super_admin', 'admin'])) {
            if ($user->hasRole('project_manager')) {
                $q->whereRaw('1=0');
            } elseif ($user->hasRole('vendor_admin')) {
                // vendor_admin sees all satisfaction surveys
            } elseif ($user->hasRole('vendor_staff')) {
                $q->whereRaw('1=0');
            } elseif ($user->hasRole('service_unit')) {
                $q->where('service_unit_id', $user->service_unit_id);
            } elseif ($user->hasRole('viewer')) {
                // viewer sees all, no filter needed
            }
        }

        if ($this->search) {
            $q->where(function ($qq) {
                $qq->where('overall_evaluation', 'like', "%{$this->search}%")
                    ->orWhereHas('serviceUnit', fn($q2) => $q2->where('name', 'like', "%{$this->search}%"))
                    ->orWhereHas('personnel', fn($q2) => $q2->where('name', 'like', "%{$this->search}%"));
            });
        }
        if ($this->serviceUnitId) {
            $q->where('service_unit_id', (int)$this->serviceUnitId);
        }
        if ($this->satisfactionLevel) {
            $q->where('satisfaction_level', $this->satisfactionLevel);
        }
        if ($this->status !== '') {
            $q->where('status', (int)$this->status);
        }
        if ($this->dateFrom) {
            $q->where('survey_date', '>=', $this->dateFrom);
        }
        if ($this->dateTo) {
            $q->where('survey_date', '<=', $this->dateTo);
        }

        return view('livewire.satisfaction-survey.satisfaction-survey-list', [
            'surveys' => $q->latest('survey_date')->paginate(15),
            'serviceUnits' => ServiceUnit::where('status', 1)->orderBy('name')->get(),
        ]);
    }
}
