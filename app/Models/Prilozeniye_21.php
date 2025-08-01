<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Prilozeniye_21 extends Model
{
    use HasFactory;

    protected $fillable = [
        'number_acts',
        'name_object',
        'city',
        'day',
        'month',
        'year',
        'pred_zakaz',
        'pred_tn',
        'pred_gp',
        'geodez_docs',
        'tech_docs_1',
        'tech_docs_2',
        'prilojenie_1',
        'prilojenie_2',
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
