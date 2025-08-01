<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Prilozeniye_29 extends Model
{
    use HasFactory;

    protected $fillable = [
        'stroi_org',
        'name_address',
        'number_acts',
        'number_fund',
        'number_opora',
        'day',
        'month',
        'year',
        'komisiya',
        'name_stroi',
        'stroi_fio',
        'tn_fio',
        'ushireniya_numb',
        'opora_numb',
        'chertej',
        'diametr',
        'tolshina',
        'dlina',
        'otmetka',
        'skv_diametr',
        'skv_verh',
        'skv_dno',
        'stanok_neskal',
        'neskal_glubina',
        'stanok_skal',
        'skal_glubina',
        'diametr_razbur',
        'otmetk_podoshv',
        'silindr_visota',
        'uroven_vod',
        'voda_vne',
        'grunt_osnov',
        'otkloneniya_vdol',
        'otkloneniya_poperek',
        'otkloneniya_vertical',
        'dlina_karkas',
        'diametr_karkas',
        'niz_karkas',
        'armkarkas_s',
        'sterjen_diam',
        'sterjen_mm',
        'project',
        'number_project',
        'ustanovleno',
        'postanovili',
        'kachestvo',
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
