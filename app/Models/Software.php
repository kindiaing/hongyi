<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Software extends Model
{
    use SoftDeletes;

    protected $table = 'software';

    protected $fillable = [
        'software_no',
        'software_name',
        'version',
        'deploy_environment',
        'deploy_server',
        'license_info',
        'sub_contract_id',
        'vendor_id',
        'maintenance_start_date',
        'maintenance_end_date',
        'maintenance_cycle',
        'sla_level',
        'is_resident_required',
        'resident_location',
        'resident_cycle',
        'work_start_time',
        'work_end_time',
        'emergency_response_time',
        'status',
        'remark',
        'created_by',
    ];

    protected $casts = [
        'maintenance_start_date' => 'date',
        'maintenance_end_date' => 'date',
        'is_resident_required' => 'boolean',
        'emergency_response_time' => 'integer',
        'status' => 'integer',
    ];

    public function subContract(): BelongsTo
    {
        return $this->belongsTo(SubContract::class, 'sub_contract_id');
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function maintenanceLogs(): HasMany
    {
        return $this->hasMany(SoftwareMaintenanceLog::class, 'software_id');
    }

    public function faults(): HasMany
    {
        return $this->hasMany(SoftwareFault::class, 'software_id');
    }

    public function getStatusTextAttribute(): string
    {
        return match ($this->status) {
            0 => '停用',
            1 => '运行中',
            2 => '维护中',
            default => '未知',
        };
    }
}
