<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PrilozeniyeGotovnPodmostei extends Model
{
    use HasFactory;

    protected $fillable = [
        'number_act',
        'day',
        'month',
        'year',
        'stroika_address',
        'lift_type',
        'lift_number',
        'prim_1',
        'prim_2',
        // Подписи комиссии
        'sdat_fio',
        'sdat_dolzh',
        'sdat_sign',
        'sdat_decipher',
        'sdat_date',
        'prinyal_an_fio',
        'prinyal_an_dolzh',
        'prinyal_an_sign',
        'prinyal_an_decipher',
        'prinyal_an_date',
        'prinyal_mont_fio',
        'prinyal_mont_dolzh',
        'prinyal_mont_sign',
        'prinyal_mont_decipher',
        'prinyal_mont_date',
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
