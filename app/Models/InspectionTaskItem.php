<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InspectionTaskItem extends Model
{
    protected $table = 'inspection_task_items';

    protected $fillable = [
        'task_id',
        'template_item_id',
        'result_value',
        'is_normal',
        'abnormal_desc',
    ];

    protected $casts = [
        'is_normal' => 'integer',
    ];

    public function task(): BelongsTo
    {
        return $this->belongsTo(InspectionTask::class, 'task_id');
    }

    public function templateItem(): BelongsTo
    {
        return $this->belongsTo(InspectionTemplateItem::class, 'template_item_id');
    }

    public function photos(): HasMany
    {
        return $this->hasMany(InspectionTaskPhoto::class, 'task_item_id');
    }
}
