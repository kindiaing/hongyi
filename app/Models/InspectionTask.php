<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InspectionTask extends Model
{
    protected $table = 'inspection_tasks';

    protected $fillable = [
        'task_no',
        'plan_id',
        'template_id',
        'task_name',
        'task_type',
        'vendor_id',
        'target_type',
        'target_id',
        'assignee_id',
        'planned_date',
        'planned_time',
        'start_time',
        'end_time',
        'sign_in_lat',
        'sign_in_lng',
        'sign_in_address',
        'overall_result',
        'exception_desc',
        'status',
        'auditor_id',
        'audit_time',
        'audit_result',
        'audit_comment',
        'rectification_required',
        'rectification_deadline',
    ];

    protected $casts = [
        'planned_date' => 'date',
        'planned_time' => 'datetime:H:i',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'audit_time' => 'datetime',
        'rectification_deadline' => 'date',
        'sign_in_lat' => 'decimal:7',
        'sign_in_lng' => 'decimal:7',
        'overall_result' => 'integer',
        'status' => 'integer',
        'audit_result' => 'integer',
        'rectification_required' => 'boolean',
    ];

    public function plan(): BelongsTo
    {
        return $this->belongsTo(InspectionPlan::class, 'plan_id');
    }

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

    public function auditor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'auditor_id');
    }

    public function taskItems(): HasMany
    {
        return $this->hasMany(InspectionTaskItem::class, 'task_id');
    }

    public function photos(): HasMany
    {
        return $this->hasMany(InspectionTaskPhoto::class, 'task_id');
    }

    public function getStatusTextAttribute(): string
    {
        return match ($this->status) {
            0 => '待执行',
            1 => '执行中',
            2 => '待审核',
            3 => '已完成',
            4 => '已逾期',
            default => '未知',
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            0 => 'zinc',
            1 => 'blue',
            2 => 'amber',
            3 => 'emerald',
            4 => 'red',
            default => 'zinc',
        };
    }

    public function getTaskTypeTextAttribute(): string
    {
        return match ($this->task_type) {
            'inspection' => '巡检',
            'visit' => '回访',
            default => $this->task_type,
        };
    }

    public function getOverallResultTextAttribute(): ?string
    {
        if ($this->overall_result === null) return null;
        return $this->overall_result === 1 ? '正常' : '异常';
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
