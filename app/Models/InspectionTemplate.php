<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InspectionTemplate extends Model
{
    use SoftDeletes;

    protected $table = 'inspection_templates';

    protected $fillable = [
        'template_name',
        'template_type',
        'category',
        'description',
        'is_enabled',
        'created_by',
    ];

    protected $casts = [
        'is_enabled' => 'boolean',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(InspectionTemplateItem::class, 'template_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getTemplateTypeTextAttribute(): string
    {
        return match ($this->template_type) {
            'inspection' => '巡检',
            'visit' => '回访',
            default => $this->template_type,
        };
    }
}
