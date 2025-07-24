<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Prilozeniye_24 extends Model
{
    use HasFactory;

    protected $fillable = [
        'city',
        'day',
        'number_act',
        'month',
        'year',
        'pred_zk',
        'pred_gp',
        'pred_upr',
        'name_object_address',
        'otmetka_reper',
        'null_otmetka',
        'name_zdamiya',
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
