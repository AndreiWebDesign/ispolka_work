<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Prilozeniye_30 extends Model
{
    use HasFactory;

    protected $fillable = [
        'act_number',
        'city',
        'day',
        'month',
        'year',
        'pred_tn_zastroi',
        'injener_1',
        'injener_2',
        'glav_injener_1',
        'glav_injener_2',
        'proizod_rabot',
        'number_zeml_uch',
        'address',
        'grunt_vod',
        'plan_otm',
        'glubina',
        'glubina_v_prep',
        'prepyatstv',
        'perv_osnov',
        'davl_grunt',
        'davl_grunt_2',
        'davl_project',
        'ukrep_vyzyv',
        'osad_sh',
        'kom_davlemiy',
        'avtor',
        'tn_zastr',
        'inj_1',
        'inj_2',
        'glav_injener',
        'proizvod_rabot',
        'passport_id',
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
