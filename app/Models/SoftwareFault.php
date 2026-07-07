<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SoftwareFault extends Model
{
    protected $table = 'software_faults';

    protected $fillable = [
        'software_id',
        'fault_no',
        'fault_level',
        'title',
        'description',
        'reporter_name',
        'reporter_phone',
        'report_time',
        'handler_id',
        'handle_time',
        'handle_result',
        'resolve_time',
        'is_sla_met',
        'status',
        'remark',
    ];

    protected $casts = [
        'report_time' => 'datetime',
        'handle_time' => 'datetime',
        'resolve_time' => 'datetime',
        'is_sla_met' => 'integer',
        'status' => 'integer',
    ];

    public function software()
    {
        return $this->belongsTo(Software::class, 'software_id');
    }

    public function handler()
    {
        return $this->belongsTo(Personnel::class, 'handler_id');
    }

    public function getStatusTextAttribute(): string
    {
        return match ($this->status) {
            0 => '待处理',
            1 => '处理中',
            2 => '已解决',
            3 => '已关闭',
            default => '未知',
        };
    }
}
