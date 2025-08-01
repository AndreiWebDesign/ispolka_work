<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Prilozeniye_74 extends Model
{
    use HasFactory;

    protected $fillable = [
        'number_acts',
        'city',
        'day',
        'month',
        'year',
        'an',            // авторский надзор
        'tnz',           // технический надзор заказчика
        'po',            // подрядная организация
        'subpo',         // субподрядная (монтажная) организация
        'exploat',       // эксплуатирующая организация (название, лицензии)
        'exploat_fio',   // фамилия и инициалы эксплуатирующей организации
        'object_name',   // наименование и адрес объекта
        'docs',
        'passport_id',// представленные документы, перечень
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
