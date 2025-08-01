<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Prilozeniye_67 extends Model
{
    use HasFactory;

    protected $fillable = [
        'number_acts',
        'name_rabot',
        'name_address',
        'date',
        'month',
        'year',
        'cmo_1',
        'cmo_2',
        'tnz_1',
        'tnz_2',
        'smo_prov_1_0',
        'smo_prov_1_1',
        'rabot',
        'psd_1',
        'psd_2',
        'material_1',
        'material_2',
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
