<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MainContractManager extends Model
{
    protected $table = 'main_contract_managers';

    public $timestamps = false;

    protected $fillable = [
        'main_contract_id',
        'user_id',
    ];

    public function mainContract(): BelongsTo
    {
        return $this->belongsTo(MainContract::class, 'main_contract_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
