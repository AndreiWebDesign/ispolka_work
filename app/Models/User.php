<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'position',
        'role',
        'organization_name',
        'bin',
        'organization_id',
        'is_profile_complete',
        'available_passports',
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function passports()
    {
        return $this->belongsToMany(Passport::class, 'project_user_roles', 'user_id', 'passport_id')
            ->withPivot('role')
            ->withTimestamps();
    }


    public function projectInvitations()
    {
        return $this->hasMany(ProjectInvitation::class);
    }

    public function invitedPassports()
    {
        return $this->belongsToMany(
            Passport::class,
            'project_invitations',
            'user_id',
            'passport_id'
        )->withPivot('role', 'status');
    }
    public function payments()
    {
        return $this->hasMany(\App\Models\Payment::class);
    }
}
