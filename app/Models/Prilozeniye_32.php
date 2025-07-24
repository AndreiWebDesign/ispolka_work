<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Prilozeniye_32 extends Model
{
    use HasFactory;

    protected $fillable = [
        'stroi_org',
        'name_address',
        'number_acts',
        'day#0',
        'month',
        'year',
        'komisia',
        'osnovaniye',
        'name_adress_naznacheniye_2',
        'name_adress_naznacheniye_1',
        'rabochie',
        'razrabotanye',
        'otklonenie_1',
        'otklonenie_2',
        'day#1',
        'year_sogl',
        'jurnal_proizv',
        'jurnan_avtor',
        'akts',
        'sertifikat',
        'passport',
        'ustanovila_1',
        'ustanovila_2',
        'chitat_rabots',
        'priznat',
        'razreshit',
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
