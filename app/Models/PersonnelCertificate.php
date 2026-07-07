<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonnelCertificate extends Model
{
    protected $table = 'personnel_certificates';

    protected $fillable = [
        'personnel_id',
        'certificate_name',
        'certificate_no',
        'issuing_authority',
        'issue_date',
        'expiry_date',
        'attachment_url',
        'status',
    ];

    protected $casts = [
        'issue_date' => 'date',
        'expiry_date' => 'date',
        'status' => 'integer',
    ];

    public function personnel()
    {
        return $this->belongsTo(Personnel::class, 'personnel_id');
    }
}
