<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MainContract extends Model
{
    use SoftDeletes;

    protected $table = 'main_contracts';

    protected $fillable = [
        'contract_no',
        'contract_name',
        'party_a_name',
        'party_a_contact',
        'party_a_phone',
        'party_b_name',
        'total_amount',
        'signed_date',
        'start_date',
        'end_date',
        'payment_terms',
        'service_scope',
        'status',
        'project_level',
        'attachment_visible',
        'remark',
        'created_by',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'signed_date' => 'date',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function subContracts(): HasMany
    {
        return $this->hasMany(SubContract::class, 'main_contract_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(ContractAttachment::class, 'contract_id')
            ->where('contract_type', 'main');
    }

    public function renewals(): HasMany
    {
        return $this->hasMany(ContractRenewal::class, 'contract_id')
            ->where('contract_type', 'main');
    }

    public function managers(): HasMany
    {
        return $this->hasMany(MainContractManager::class, 'main_contract_id');
    }
}
