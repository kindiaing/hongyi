<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContractAttachment extends Model
{
    protected $table = 'contract_attachments';

    protected $fillable = [
        'contract_type',
        'contract_id',
        'file_name',
        'file_path',
        'file_size',
        'file_type',
        'version_type',
        'description',
        'is_sealed',
        'uploaded_by',
    ];

    protected $casts = [
        'is_sealed' => 'boolean',
        'file_size' => 'integer',
    ];

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function getVersionTypeTextAttribute(): string
    {
        return match ($this->version_type) {
            'word' => '电子版',
            'pdf_sealed' => '盖章版',
            default => '其他',
        };
    }

    public function getFileSizeTextAttribute(): string
    {
        $size = $this->file_size;
        if ($size >= 1024 * 1024) {
            return round($size / (1024 * 1024), 2) . ' MB';
        }
        if ($size >= 1024) {
            return round($size / 1024, 2) . ' KB';
        }
        return $size . ' B';
    }
}
