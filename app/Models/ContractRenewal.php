<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContractRenewal extends Model
{
    protected $table = 'contract_renewals';

    protected $fillable = [
        'contract_type',
        'contract_id',
        'renewal_no',
        'previous_end_date',
        'new_start_date',
        'new_end_date',
        'new_amount',
        'renewal_reason',
        'status',
        'approved_by',
        'approved_at',
        'created_by',
    ];

    protected $casts = [
        'new_amount' => 'decimal:2',
        'previous_end_date' => 'date',
        'new_start_date' => 'date',
        'new_end_date' => 'date',
        'approved_at' => 'datetime',
    ];

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
