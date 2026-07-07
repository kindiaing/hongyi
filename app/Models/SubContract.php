<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SubContract extends Model
{
    use SoftDeletes;

    protected $table = 'sub_contracts';

    protected $fillable = [
        'main_contract_id',
        'contract_no',
        'contract_name',
        'vendor_id',
        'service_unit_id',
        'contract_type',
        'maintenance_type',
        'sub_amount',
        'signed_date',
        'start_date',
        'end_date',
        'service_scope',
        'sla_level',
        'payment_terms',
        'status',
        'attachment_visible',
        'remark',
        'created_by',
    ];

    protected $casts = [
        'sub_amount' => 'decimal:2',
        'signed_date' => 'date',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function mainContract(): BelongsTo
    {
        return $this->belongsTo(MainContract::class, 'main_contract_id');
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(ContractAttachment::class, 'contract_id')
            ->where('contract_type', 'sub');
    }

    public function renewals(): HasMany
    {
        return $this->hasMany(ContractRenewal::class, 'contract_id')
            ->where('contract_type', 'sub');
    }

    public function personnel(): HasMany
    {
        return $this->hasMany(SubContractPersonnel::class, 'sub_contract_id');
    }

    public function managers(): HasMany
    {
        return $this->hasMany(SubContractManager::class, 'sub_contract_id');
    }

    public function serviceUnit(): BelongsTo
    {
        return $this->belongsTo(ServiceUnit::class, 'service_unit_id');
    }
}
