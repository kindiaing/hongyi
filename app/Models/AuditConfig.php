<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditConfig extends Model
{
    protected $table = 'audit_configs';

    protected $fillable = [
        'audit_type',
        'audit_name',
        'audit_module',
        'is_enabled',
        'record_create',
        'record_update',
        'record_delete',
        'record_view',
        'record_old_data',
        'record_new_data',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'is_enabled' => 'boolean',
            'record_create' => 'boolean',
            'record_update' => 'boolean',
            'record_delete' => 'boolean',
            'record_view' => 'boolean',
            'record_old_data' => 'boolean',
            'record_new_data' => 'boolean',
        ];
    }

    /**
     * 检查指定操作类型是否应被记录
     */
    public static function shouldRecord(string $auditType, string $operation = 'create'): bool
    {
        $config = static::where('audit_type', $auditType)->first();
        if (!$config || !$config->is_enabled) {
            return false;
        }
        return match($operation) {
            'create' => $config->record_create,
            'update' => $config->record_update,
            'delete' => $config->record_delete,
            'view' => $config->record_view,
            default => false,
        };
    }
}
