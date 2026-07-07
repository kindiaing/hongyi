<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Schedule extends Model
{
    protected $table = 'schedules';

    protected $fillable = [
        'software_id',
        'personnel_id',
        'shift_date',
        'shift_type',
        'start_time',
        'end_time',
        'is_replaced',
        'replaced_by',
        'replace_reason',
        'status',
        'created_by',
    ];

    protected $casts = [
        'shift_date' => 'date',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'is_replaced' => 'boolean',
        'status' => 'integer',
    ];

    public function software(): BelongsTo
    {
        return $this->belongsTo(Software::class, 'software_id');
    }

    public function personnel(): BelongsTo
    {
        return $this->belongsTo(Personnel::class, 'personnel_id');
    }

    public function replacedByPersonnel(): BelongsTo
    {
        return $this->belongsTo(Personnel::class, 'replaced_by');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getShiftTypeTextAttribute(): string
    {
        return match ($this->shift_type) {
            'day' => '白班',
            'night' => '夜班',
            'holiday' => '节假日班',
            default => $this->shift_type,
        };
    }

    public function getStatusTextAttribute(): string
    {
        return match ($this->status) {
            0 => '取消',
            1 => '正常',
            default => '未知',
        };
    }
}
