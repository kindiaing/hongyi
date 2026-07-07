<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataDictionary extends Model
{
    protected $table = 'data_dictionaries';

    protected $fillable = [
        'category',
        'code',
        'name',
        'value',
        'sort_order',
        'is_enabled',
        'description',
    ];

    protected $casts = [
        'sort_order' => 'integer',
        'is_enabled' => 'boolean',
    ];
}
