<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class IntermediateAccept extends Model
{
    use HasFactory;

    protected $fillable = [
        'passport_id',
        'act_number',
        'act_date',
        'object_name',
        'contractor_representative',
        'tech_supervisor_representative',
        'author_supervisor_representative',
        'additional_participants',
        'construction_stage',
        'accepted_elements',
        'hidden_works_status',
        'compliance_info',
        'psd_info',
        'geodetic_info',
        'test_results',
        'commission_decision',
        'next_works',
        'contractor_sign_name',
        'tech_supervisor_sign_name',
        'author_supervisor_sign_name',
        'type',
    ];

    public function passport()
    {
        return $this->belongsTo(\App\Models\Passport::class);
    }

    public function signatures()
    {
        return $this->morphMany(ActSignature::class, 'actable');
    }
}
