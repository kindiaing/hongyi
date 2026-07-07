<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InspectionTemplateItem extends Model
{
    protected $table = 'inspection_template_items';

    protected $fillable = [
        'template_id',
        'item_name',
        'item_type',
        'options',
        'standard',
        'is_required',
        'sort_order',
    ];

    protected $casts = [
        'options' => 'array',
        'is_required' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function template(): BelongsTo
    {
        return $this->belongsTo(InspectionTemplate::class, 'template_id');
    }

    public function getItemTypeTextAttribute(): string
    {
        return match ($this->item_type) {
            'text' => '文本',
            'single_choice' => '单选',
            'multiple_choice' => '多选',
            'number' => '数值',
            'photo' => '拍照',
            default => $this->item_type,
        };
    }
}
