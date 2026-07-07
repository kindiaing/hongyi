<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeviceMaintenanceLog extends Model
{
    protected $table = 'device_maintenance_logs';

    protected $fillable = [
        'device_id',
        'maintenance_date',
        'maintenance_type',
        'description',
        'result',
        'cost',
        'service_provider',
        'technician',
        'next_maintenance_date',
        'attachments',
        'created_by',
    ];

    protected $casts = [
        'maintenance_date' => 'date',
        'next_maintenance_date' => 'date',
        'cost' => 'decimal:2',
        'attachments' => 'array',
    ];

    public function device()
    {
        return $this->belongsTo(HardwareDevice::class, 'device_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
