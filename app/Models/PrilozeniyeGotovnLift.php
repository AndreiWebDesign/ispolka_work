<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PrilozeniyeGotovnLift extends Model
{
    use HasFactory;

    protected $fillable = [
        'number_acts',
        'day',
        'month',
        'year',
        'stroika_address',
        'lift',
        'number_lift',
        'tnp',
        'tnp_dolzj',
        'an',
        'an_dplj',
        'mo',
        'mo_dolj',
        'otdel_raboty',
        'lift_number',
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
