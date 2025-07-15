<?php

namespace App\Models;
use Model;
use User;

class ProjectInvitation extends Model
{
    protected $fillable = ['user_id', 'project_id', 'role', 'status'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
