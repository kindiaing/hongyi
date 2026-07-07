<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HardwareDevice extends Model
{
    use SoftDeletes;

    protected $table = 'hardware_devices';

    protected $fillable = [
        'device_no',
        'device_name',
        'device_type',
        'brand',
        'model',
        'serial_no',
        'specification',
        'location',
        'sub_contract_id',
        'vendor_id',
        'purchase_date',
        'supplier',
        'purchase_amount',
        'warranty_period',
        'start_date',
        'expiry_date',
        'scrap_date',
        'maintenance_cycle',
        'next_maintenance_date',
        'status',
        'qrcode',
        'remark',
        'created_by',
    ];

    protected $casts = [
        'purchase_amount' => 'decimal:2',
        'purchase_date' => 'date',
        'start_date' => 'date',
        'expiry_date' => 'date',
        'scrap_date' => 'date',
        'next_maintenance_date' => 'date',
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
        return $this->hasMany(DeviceMaintenanceLog::class, 'device_id');
    }

    public function getStatusTextAttribute(): string
    {
        return match ($this->status) {
            0 => '报废',
            1 => '在用',
            2 => '维修中',
            3 => '闲置',
            default => '未知',
        };
    }
}
