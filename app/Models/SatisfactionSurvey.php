<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SatisfactionSurvey extends Model
{
    use SoftDeletes;

    protected $table = 'satisfaction_surveys';

    protected $fillable = [
        'plan_id',
        'service_unit_id',
        'personnel_id',
        'survey_date',
        'satisfaction_level',
        'service_attitude_score',
        'response_speed_score',
        'technical_level_score',
        'overall_evaluation',
        'improvement_suggestions',
        'surveyor_id',
        'status',
        'remark',
        'created_by',
    ];

    protected $casts = [
        'survey_date' => 'date',
        'service_attitude_score' => 'integer',
        'response_speed_score' => 'integer',
        'technical_level_score' => 'integer',
        'status' => 'integer',
    ];

    public function plan(): BelongsTo
    {
        return $this->belongsTo(SatisfactionSurveyPlan::class, 'plan_id');
    }

    public function serviceUnit(): BelongsTo
    {
        return $this->belongsTo(ServiceUnit::class, 'service_unit_id');
    }

    public function personnel(): BelongsTo
    {
        return $this->belongsTo(Personnel::class, 'personnel_id');
    }

    public function surveyor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'surveyor_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getSatisfactionLevelTextAttribute(): string
    {
        return match ($this->satisfaction_level) {
            'very_satisfied' => '非常满意',
            'satisfied' => '满意',
            'general' => '一般',
            'dissatisfied' => '不满意',
            default => '未知',
        };
    }

    public function getStatusTextAttribute(): string
    {
        return match ($this->status) {
            0 => '待回访',
            1 => '已完成',
            default => '未知',
        };
    }

    public function getAverageScoreAttribute(): ?float
    {
        $scores = array_filter([
            $this->service_attitude_score,
            $this->response_speed_score,
            $this->technical_level_score,
        ], fn ($s) => $s !== null);

        if (empty($scores)) {
            return null;
        }

        return round(array_sum($scores) / count($scores), 1);
    }
}
