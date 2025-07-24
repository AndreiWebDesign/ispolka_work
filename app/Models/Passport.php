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
    public function userRole()
    {
        return $this->belongsToMany(User::class, 'project_user_roles', 'passport_id', 'user_id')
            ->withPivot('role')
            ->wherePivot('user_id', auth()->id());
    }
    public function hiddenWorks()
    {
        return $this->hasMany(\App\Models\HiddenWork::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'project_user_roles')
            ->withPivot('role') // если хранишь роль
            ->withTimestamps();
    }

    public function invitations()
    {
        return $this->hasMany(ProjectInvitation::class, 'passport_id');
    }

    public function intermediateAccepts()
    {
        return $this->hasMany(\App\Models\IntermediateAccept::class);
    }
    public function acts()
    {
        $hiddenWorks = $this->hiddenWorks;
        $intermediateAccepts = $this->intermediateAccepts;

        return $hiddenWorks->concat($intermediateAccepts);
    }
    public function getActsAttribute()
    {
        $hiddenWorks = $this->hiddenWorks->map(function ($item) {
            $item->act_type = 'hidden_work'; // или 'hidden'
            return $item;
        });

        $intermediateAccepts = $this->intermediateAccepts->map(function ($item) {
            $item->act_type = 'intermediate_accept'; // как в БД
            return $item;
        });

        return $hiddenWorks
            ->concat($intermediateAccepts)
            ->sortBy('act_date')
            ->values();
    }

}
