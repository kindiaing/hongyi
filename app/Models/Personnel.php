<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Personnel extends Model
{
    use SoftDeletes;

    protected $table = 'personnel';

    protected $fillable = [
        'vendor_id',
        'user_id',
        'name',
        'id_card',
        'phone',
        'email',
        'gender',
        'birth_date',
        'position',
        'job_title',
        'entry_date',
        'leave_date',
        'status',
        'is_resident',
        'resident_location',
        'work_start_time',
        'work_end_time',
        'emergency_contact',
        'emergency_phone',
        'remark',
    ];

    protected $casts = [
        'gender' => 'integer',
        'birth_date' => 'date',
        'entry_date' => 'date',
        'leave_date' => 'date',
        'status' => 'integer',
        'is_resident' => 'integer',
    ];

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function certificates(): HasMany
    {
        return $this->hasMany(PersonnelCertificate::class, 'personnel_id');
    }

    public function subContracts(): HasMany
    {
        return $this->hasMany(SubContractPersonnel::class, 'personnel_id');
    }

    public function getGenderTextAttribute(): string
    {
        return match ($this->gender) {
            0 => '女',
            1 => '男',
            default => '-',
        };
    }

    public function getStatusTextAttribute(): string
    {
        return match ($this->status) {
            0 => '离职',
            1 => '在职',
            2 => '休假',
            default => '未知',
        };
    }
}
