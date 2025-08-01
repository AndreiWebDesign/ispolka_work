<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Prilozeniye_28 extends Model
{
    use HasFactory;

    protected $fillable = [
        'number_acts_1',
        'stroi_org',
        'name_address',
        'day',
        'month',
        'year',
        'komisiya',
        'svain_osn_1',
        'svain_osn_2',
        'svain_osn_3',
        'krepleniye_numb',
        'name_org',
        'jurn_pr',
        'jurn_an',
        'jurn_tn',
        'otmetka_grunta',
        'srezka_otmetka',
        'vyryt_otmetka',
        'project_otmetka',
        'passport-svai',
        'reper',
        'otmetka-reper',
        'krepleniye',
        'krep-material',
        'glubina_ot',
        'glubina_do',
        'glubina_project',
        'glubina_org',
        'sootvetstv',
        'voda_niz',
        'vodootliv',
        'vne_kotl',
        'intens_voda',
        'grynt_glubina',
        'jurnal',
        'kolvo',
        'number_acts',
        'day-act',
        'month-act',
        'year-act',
        'postanovila',
        'kachstv',
        'daln_rab',
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
