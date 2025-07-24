<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Prilozeniye_75 extends Model
{
    use HasFactory;

    protected $fillable = [
        'number_act',
        'city',
        'day',
        'month',
        'year',
        'an',            // авторский надзор: ФИО, должность/организация
        'tnz',           // технадзор заказчика: ФИО, должность/организация
        'po',            // подрядная организация: ФИО, должность/организация
        'subpo',         // субподрядная (монтажная): ФИО, должность/организация
        'exploat',       // эксплуатирующая организация: ФИО, должность/организация
        'object_name',   // наименование и адрес объекта
        'docs',          // предъявленная документация (текст или список)
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
