<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SatisfactionSurveyPlan extends Model
{
    use SoftDeletes;

    protected $table = 'satisfaction_survey_plans';

    protected $fillable = [
        'plan_name',
        'service_unit_id',
        'vendor_id',
        'cycle_type',
        'cycle_month',
        'cycle_day',
        'start_date',
        'end_date',
        'remind_days',
        'is_enabled',
        'next_execute_at',
        'last_executed_at',
        'remark',
        'created_by',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'remind_days' => 'integer',
        'is_enabled' => 'boolean',
        'cycle_month' => 'integer',
        'cycle_day' => 'integer',
        'next_execute_at' => 'datetime',
        'last_executed_at' => 'datetime',
    ];

    public function serviceUnit(): BelongsTo
    {
        return $this->belongsTo(ServiceUnit::class, 'service_unit_id');
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function surveys(): HasMany
    {
        return $this->hasMany(SatisfactionSurvey::class, 'plan_id');
    }

    public function getCycleTypeTextAttribute(): string
    {
        return match ($this->cycle_type) {
            'monthly' => '月度',
            'quarterly' => '季度',
            'annually' => '年度',
            'custom' => '自定义',
            default => '未知',
        };
    }
}
