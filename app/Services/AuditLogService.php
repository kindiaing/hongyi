<?php

namespace App\Services;

use App\Models\AuditConfig;
use App\Models\OperationLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class AuditLogService
{
    /**
     * 记录操作日志
     *
     * @param string $auditType 审计类型 (如: contract, device, user 等)
     * @param string $operation 操作类型 (create, update, delete, view)
     * @param string $action 操作描述 (如: 创建合同, 更新设备 等)
     * @param string $description 详细描述
     * @param array|null $oldData 变更前数据
     * @param array|null $newData 变更后数据
     * @return OperationLog|null
     */
    public static function record(
        string $auditType,
        string $operation,
        string $action,
        string $description = '',
        ?array $oldData = null,
        ?array $newData = null
    ): ?OperationLog {
        if (!AuditConfig::shouldRecord($auditType, $operation)) {
            return null;
        }

        $config = AuditConfig::where('audit_type', $auditType)->first();
        $recordOld = $config?->record_old_data ?? false;
        $recordNew = $config?->record_new_data ?? false;

        return OperationLog::create([
            'user_id' => Auth::id(),
            'method' => Request::method() ?: 'CLI',
            'path' => Request::path() ?: '-',
            'ip' => Request::ip() ?: '127.0.0.1',
            'user_agent' => Request::userAgent() ?: null,
            'action' => $action,
            'description' => $description,
            'old_data' => ($recordOld && $oldData) ? $oldData : null,
            'new_data' => ($recordNew && $newData) ? $newData : null,
            'created_at' => now(),
        ]);
    }

    /**
     * 快速记录创建操作
     */
    public static function create(string $auditType, string $action, string $description, array $newData = []): ?OperationLog
    {
        return static::record($auditType, 'create', $action, $description, null, $newData);
    }

    /**
     * 快速记录编辑操作
     */
    public static function update(string $auditType, string $action, string $description, array $oldData, array $newData): ?OperationLog
    {
        return static::record($auditType, 'update', $action, $description, $oldData, $newData);
    }

    /**
     * 快速记录删除操作
     */
    public static function delete(string $auditType, string $action, string $description, array $oldData = []): ?OperationLog
    {
        return static::record($auditType, 'delete', $action, $description, $oldData, null);
    }

    /**
     * 快速记录查看操作
     */
    public static function view(string $auditType, string $action, string $description): ?OperationLog
    {
        return static::record($auditType, 'view', $action, $description);
    }
}
