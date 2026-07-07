<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vendor extends Model
{
    use SoftDeletes;

    protected $table = 'vendors';

    protected $fillable = [
        'name',
        'short_name',
        'unified_code',
        'type',
        'qualification_level',
        'legal_person',
        'contact_name',
        'contact_phone',
        'contact_email',
        'address',
        'bank_name',
        'bank_account',
        'cooperation_status',
        'remark',
    ];

    protected $casts = [
        'cooperation_status' => 'integer',
    ];
}
