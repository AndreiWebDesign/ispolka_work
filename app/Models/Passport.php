<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Passport extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer',
        'customer_responsible',
        'contractor',
        'contractor_responsible',
        'tech_supervisor',
        'tech_supervisor_responsible',
        'author_supervisor',
        'author_supervisor_responsible',
        'project_developer',
        'city',
        'locality',
        'psd_number',
        'object_name',
        'user_id',
    ];

    public function hiddenWorks()
    {
        return $this->hasMany(\App\Models\HiddenWork::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
