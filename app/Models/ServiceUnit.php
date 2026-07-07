<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ServiceUnit extends Model
{
    use SoftDeletes;

    protected $table = 'service_units';

    protected $fillable = [
        'name',
        'short_name',
        'address',
        'contact_name',
        'contact_phone',
        'contact_email',
        'status',
        'remark',
        'created_by',
    ];

    protected $casts = [
        'status' => 'integer',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function surveyPlans(): HasMany
    {
        return $this->hasMany(SatisfactionSurveyPlan::class, 'service_unit_id');
    }

    public function surveys(): HasMany
    {
        return $this->hasMany(SatisfactionSurvey::class, 'service_unit_id');
    }

    public function contacts(): HasMany
    {
        return $this->hasMany(ServiceUnitContact::class, 'service_unit_id')->orderBy('is_primary', 'desc');
    }

    public function primaryContact(): BelongsTo
    {
        return $this->belongsTo(ServiceUnitContact::class, 'id', 'service_unit_id')->where('is_primary', 1);
    }

    public function getStatusTextAttribute(): string
    {
        return match ($this->status) {
            0 => '停用',
            1 => '启用',
            default => '未知',
        };
    }
}
