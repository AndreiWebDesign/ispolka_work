<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Prilozeniye_22 extends Model
{
    use HasFactory;

    protected $fillable = [
        'number_acts',
        'month',
        'city',
        'name_object',
        'pred_sm_pered_fio',
        'pred_sm_prinim_fio',
        'name_object_1',
        'pred_sm_pered_comp',
        'pred_sm_prinim_comp',
        'name_object_2',
        'prilojeniya',
        'pred_sm_pered',
        'pred_sm_prinim',
        'day',
        'year',
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
