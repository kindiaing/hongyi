<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SoftwareMaintenanceLog extends Model
{
    protected $table = 'software_maintenance_logs';

    protected $fillable = [
        'software_id',
        'maintenance_date',
        'maintenance_type',
        'description',
        'result',
        'duration',
        'personnel_id',
        'attachments',
        'created_by',
    ];

    protected $casts = [
        'maintenance_date' => 'date',
        'duration' => 'integer',
        'attachments' => 'array',
    ];

    public function software()
    {
        return $this->belongsTo(Software::class, 'software_id');
    }

    public function personnel()
    {
        return $this->belongsTo(Personnel::class, 'personnel_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
