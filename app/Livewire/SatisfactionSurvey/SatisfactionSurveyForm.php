<?php

namespace App\Livewire\SatisfactionSurvey;

use App\Models\SatisfactionSurvey;
use App\Models\ServiceUnit;
use App\Models\Personnel;
use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Services\AuditLogService;

#[Layout('layouts.app')]
class SatisfactionSurveyForm extends Component
{
    public ?int $surveyId = null;
    public array $form = [];
    public bool $isEditing = false;

    protected function rules(): array
    {
        return [
            'form.service_unit_id' => 'required|exists:service_units,id',
            'form.personnel_id' => 'nullable|exists:personnel,id',
            'form.survey_date' => 'required|date',
            'form.satisfaction_level' => 'required|in:very_satisfied,satisfied,general,dissatisfied',
            'form.service_attitude_score' => 'nullable|integer|min:1|max:5',
            'form.response_speed_score' => 'nullable|integer|min:1|max:5',
            'form.technical_level_score' => 'nullable|integer|min:1|max:5',
            'form.overall_evaluation' => 'nullable|string',
            'form.improvement_suggestions' => 'nullable|string',
            'form.status' => 'required|integer|in:0,1',
            'form.remark' => 'nullable|string',
        ];
    }

    public function mount(?int $id = null): void
    {
        if ($id) {
            $this->surveyId = $id;
            $this->isEditing = true;
            $this->form = SatisfactionSurvey::findOrFail($id)->toArray();
        } else {
            $this->form = [
                'survey_date' => now()->toDateString(),
                'status' => 1,
                'satisfaction_level' => 'satisfied',
            ];
        }
    }

    public function save(): void
    {
        $this->validate();
        $data = $this->form;
        $data['surveyor_id'] = auth()->id();

        if ($this->isEditing) {
            $survey = SatisfactionSurvey::findOrFail($this->surveyId);
            $oldData = $survey->toArray();
            $survey->update($data);
            $this->dispatch('notify', type: 'success', message: '回访记录已更新');
            AuditLogService::update('satisfaction', '编辑回访记录', "编辑回访记录：ID {$survey->id}", $oldData, $survey->toArray());
        } else {
            $survey = SatisfactionSurvey::create($data);
            $this->dispatch('notify', type: 'success', message: '回访记录已创建');
            AuditLogService::create('satisfaction', '创建回访记录', "创建回访记录：ID {$survey->id}", $survey->toArray());
        }
        $this->redirect(route('satisfaction-surveys.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.satisfaction-survey.satisfaction-survey-form', [
            'serviceUnits' => ServiceUnit::where('status', 1)->orderBy('name')->get(),
            'personnelList' => Personnel::where('status', 1)->with('vendor')->orderBy('name')->get(),
        ]);
    }
}
