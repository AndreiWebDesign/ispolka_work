<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HiddenWork extends Model
{
    use HasFactory;

    protected $fillable = [
        'passport_id',
        'act_number',
        'city',
        'act_date',
        'object_name',
        'contractor_representative',
        'tech_supervisor_representative',
        'author_supervisor_representative',
        'additional_participants',
        'work_executor',
        'hidden_works',
        'psd_info',
        'materials',
        'compliance_evidence',
        'deviations',
        'start_date',
        'end_date',
        'commission_decision',
        'next_works',
        'contractor_sign_name',
        'tech_supervisor_sign_name',
        'author_supervisor_sign_name',
        'author_supervisor_sign',
        'type',
        'heading_key',   // ключ из config (например "montaj_balkonov")
        'heading_text',  // полный текст заголовка (например "Акт ... на монтаж балконов ...")
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
