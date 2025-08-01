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
        'step',
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

    public function projectInvitations()
    {
        return $this->hasMany(ProjectInvitation::class);
    }

    public function invitedUsers()
    {
        return $this->belongsToMany(
            User::class,
            'project_invitations',
            'passport_id',
            'user_id'
        )->withPivot('role', 'status');
    }

    public function acts()
    {
        return $this->hasMany(Act::class);
    }


    public function invitations()
    {
        return $this->hasMany(ProjectInvitation::class, 'passport_id');
    }

    public function intermediateAccepts()
    {
        return $this->hasMany(\App\Models\IntermediateAccept::class);
    }

    public function getActsAttribute()
    {
        $acts = collect();

        $relations = [
            'hiddenWorks' => 'hidden_works',
            'intermediateAccepts' => 'intermediate_accept',
            'prilozeniye21s' => 'prilozeniye21',
            'prilozeniye22s' => 'prilozeniye22',
            'prilozeniye23s' => 'prilozeniye23',
            'prilozeniye24s' => 'prilozeniye24',
            'prilozeniye26s' => 'prilozeniye26',
            'prilozeniye27s' => 'prilozeniye27',
            'prilozeniye28s' => 'prilozeniye28',
            'prilozeniye29s' => 'prilozeniye29',
            'prilozeniye30s' => 'prilozeniye30',
            'prilozeniye31s' => 'prilozeniye31',
            'prilozeniye32s' => 'prilozeniye32',
            'prilozeniye67s' => 'prilozeniye67',
            'prilozeniye72s' => 'prilozeniye72',
            'prilozeniye73s' => 'prilozeniye73',
            'prilozeniye74s' => 'prilozeniye74',
            'prilozeniye75s' => 'prilozeniye75',
            'prilozeniyeGotovnPodmosteis' => 'prilozeniye_gotovn_podmosteis',
            'prilozeniyeGotovnLifts' => 'prilozeniye_gotovn_lifts',
        ];

        foreach ($relations as $relation => $type) {
            if ($this->relationLoaded($relation)) {
                $acts = $acts->concat(
                    $this->$relation->map(function ($item) use ($type) {
                        $item->act_type = $type;
                        return $item;
                    })
                );
            }
        }

        return $acts->sortBy('act_date')->values();
    }
// Приложения (акты) — связи один-ко-многим

    public function prilozeniye21s()
    {
        return $this->hasMany(\App\Models\Prilozeniye_21::class);
    }

    public function prilozeniye22s()
    {
        return $this->hasMany(\App\Models\Prilozeniye_22::class);
    }

    public function prilozeniye23s()
    {
        return $this->hasMany(\App\Models\Prilozeniye_23::class);
    }

    public function prilozeniye24s()
    {
        return $this->hasMany(\App\Models\Prilozeniye_24::class);
    }

    public function prilozeniye26s()
    {
        return $this->hasMany(\App\Models\Prilozeniye_26::class);
    }

    public function prilozeniye27s()
    {
        return $this->hasMany(\App\Models\Prilozeniye_27::class);
    }

    public function prilozeniye28s()
    {
        return $this->hasMany(\App\Models\Prilozeniye_28::class);
    }

    public function prilozeniye29s()
    {
        return $this->hasMany(\App\Models\Prilozeniye_29::class);
    }

    public function prilozeniye30s()
    {
        return $this->hasMany(\App\Models\Prilozeniye_30::class);
    }

    public function prilozeniye31s()
    {
        return $this->hasMany(\App\Models\Prilozeniye_31::class);
    }

    public function prilozeniye32s()
    {
        return $this->hasMany(\App\Models\Prilozeniye_32::class);
    }

    public function prilozeniye67s()
    {
        return $this->hasMany(\App\Models\Prilozeniye_67::class);
    }

    public function prilozeniye72s()
    {
        return $this->hasMany(\App\Models\Prilozeniye_72::class);
    }

    public function prilozeniye73s()
    {
        return $this->hasMany(\App\Models\Prilozeniye_73::class);
    }

    public function prilozeniye74s()
    {
        return $this->hasMany(\App\Models\Prilozeniye_74::class);
    }

    public function prilozeniye75s()
    {
        return $this->hasMany(\App\Models\Prilozeniye_75::class);
    }

    public function prilozeniyeGotovnPodmosteis()
    {
        return $this->hasMany(\App\Models\PrilozeniyeGotovnPodmostei::class);
    }

    public function prilozeniyeGotovnLifts()
    {
        return $this->hasMany(\App\Models\PrilozeniyeGotovnLift::class);
    }
    public function actSelections()
    {
        return $this->hasMany(PassportActType::class);
    }
    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


}
