<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Prilozeniye_27 extends Model
{
    use HasFactory;

    protected $fillable = [
        'stroi_org',
        'name_address',
        'number_acts',
        'kotlovan_pod',
        'day',
        'month',
        'year',
        'komisia_fio',
        'komisia_osn',
        'komisia_osn_2',
        'komisia_osn_3',
        'pod',
        'number_krep',
        'razrab',
        'jurnal_rb_number',
        'jurnal_number',
        'akt_number',
        'vedomost',
        'estestv_poverh',
        'kotlovan_otm',
        'project_otm',
        'reper_number',
        'reper_otm',
        'vyp_iz',
        'ot_dna',
        'do_m',
        'glubina_zabivki',
        'verh_org',
        'otkloneniya_shpunt',
        'krep_verh',
        'obvyazka',
        'zamknutost_shpunt',
        'number_prilojeniya',
        'otmetka_vod',
        'otmetka_rab_gorizont_vod',
        'vodootliv',
        'grunt_dno',
        'glubina_shunt',
        'idet',
        'zaglush_key',
        'ispytaniya_grunt',
        'rachet_sopr',
        'sopr_project',
        'otmetka_razr',
        'day_shunt',
        'month_shunt',
        'year_shunt',
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
