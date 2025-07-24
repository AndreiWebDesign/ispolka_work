<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Prilozeniye_31 extends Model
{
    use HasFactory;

    protected $fillable = [
        'day',
        'month',
        'year',
        'number_acts',
        'day_izgot',
        'month_izgot',
        'seria',
        'number_obr',
        'markirovka',
        'kolvo',
        'razmer',
        'name_constr',
        'number_card',
        'class_beton',
        'vodosement',
        'osadka',
        'sek',
        'temp',
        'betonomesh',
        'forms',
        'srok_raspalubki',
        'uslovia',
        'zapic_jurnal',
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
