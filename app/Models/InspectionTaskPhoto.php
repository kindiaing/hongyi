<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InspectionTaskPhoto extends Model
{
    protected $table = 'inspection_task_photos';

    protected $fillable = [
        'task_id',
        'task_item_id',
        'photo_url',
        'photo_desc',
        'taken_at',
        'lat',
        'lng',
    ];

    protected $casts = [
        'taken_at' => 'datetime',
        'lat' => 'decimal:7',
        'lng' => 'decimal:7',
    ];

    public function task(): BelongsTo
    {
        return $this->belongsTo(InspectionTask::class, 'task_id');
    }

    public function taskItem(): BelongsTo
    {
        return $this->belongsTo(InspectionTaskItem::class, 'task_item_id');
    }
}
