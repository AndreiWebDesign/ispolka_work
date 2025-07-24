<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Prilozeniye_73 extends Model
{
    use HasFactory;

    protected $fillable = [
        'number_act',
        'city',
        'day',
        'month',
        'year',
        'an',       // авторский надзор
        'tnz',      // технический надзор заказчика
        'po',       // подрядная организация
        'subpo',    // субподрядная (монтажная) организация
        'exploat',  // эксплуатирующая организация (название, лицензия, сертификаты и др.)
        'exploat_fio', // фамилия и инициалы эксплуатирующей организации
        'object_name',
        'address',
        'docs_text', // предъявленная документация (можно хранить списком/текстом)
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
