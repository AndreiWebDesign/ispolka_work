<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use User;

class ProjectInvitation extends Model
{
    protected $fillable = ['user_id', 'passport_id', 'role', 'status'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function passport()
    {
        return $this->belongsTo(Passport::class);
    }
}
