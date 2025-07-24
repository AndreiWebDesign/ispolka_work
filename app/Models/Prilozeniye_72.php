<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Prilozeniye_72 extends Model
{
    use HasFactory;

    protected $fillable = [
        'number_acts',
        'city',
        'month',
        'year',
        'tnz',      // технический надзор заказчика
        'an',       // авторский надзор
        'po',       // подрядная организация
        'subpo',    // субподрядная (монтажная) организация
        'day',
        'name_address',
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
