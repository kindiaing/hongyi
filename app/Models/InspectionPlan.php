<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InspectionPlan extends Model
{
    protected $table = 'inspection_plans';

    protected $fillable = [
        'plan_name',
        'template_id',
        'vendor_id',
        'target_type',
        'target_id',
        'cycle_type',
        'cycle_days',
        'execute_time',
        'start_date',
        'end_date',
        'assignee_id',
        'is_enabled',
        'last_generated_at',
        'next_generate_at',
        'created_by',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'execute_time' => 'datetime:H:i',
        'last_generated_at' => 'datetime',
        'next_generate_at' => 'datetime',
        'is_enabled' => 'boolean',
        'cycle_days' => 'integer',
    ];

    public function template(): BelongsTo
    {
        return $this->belongsTo(InspectionTemplate::class, 'template_id');
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(Personnel::class, 'assignee_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(InspectionTask::class, 'plan_id');
    }

    public function getCycleTypeTextAttribute(): string
    {
        return match ($this->cycle_type) {
            'daily' => '每日',
            'weekly' => '每周',
            'biweekly' => '双周',
            'monthly' => '每月',
            'quarterly' => '每季度',
            'custom' => '自定义',
            default => $this->cycle_type,
        };
    }

    public function getTargetNameAttribute(): string
    {
        if ($this->target_type === 'software') {
            return Software::find($this->target_id)?->software_name ?? '未知软件';
        }
        if ($this->target_type === 'hardware') {
            return HardwareDevice::find($this->target_id)?->device_name ?? '未知设备';
        }
        return '未知';
    }
}
