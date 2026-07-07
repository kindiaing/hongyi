<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubContractManager extends Model
{
    protected $table = 'sub_contract_managers';

    public $timestamps = false;

    protected $fillable = [
        'sub_contract_id',
        'user_id',
    ];

    public function subContract(): BelongsTo
    {
        return $this->belongsTo(SubContract::class, 'sub_contract_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
