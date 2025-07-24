<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Prilozeniye_26 extends Model
{
    use HasFactory;

    protected $fillable = [
        'number_acts',
        'day',
        'month',
        'year',
        'glav_injener',
        'komisiay',
        'geodez_prov',
        'number_rep',
        'otmetka_rep',
        'zakl',
        'snip',
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
