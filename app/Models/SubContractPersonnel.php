<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubContractPersonnel extends Model
{
    protected $table = 'sub_contract_personnel';

    protected $fillable = [
        'sub_contract_id',
        'personnel_id',
        'assigned_at',
        'ended_at',
        'status',
        'remark',
        'created_by',
    ];

    protected $casts = [
        'assigned_at' => 'date',
        'ended_at' => 'date',
        'status' => 'integer',
    ];

    public function subContract(): BelongsTo
    {
        return $this->belongsTo(SubContract::class, 'sub_contract_id');
    }

    public function personnel(): BelongsTo
    {
        return $this->belongsTo(Personnel::class, 'personnel_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getStatusTextAttribute(): string
    {
        return match ($this->status) {
            0 => '已移除',
            1 => '在职',
            default => '未知',
        };
    }
}
