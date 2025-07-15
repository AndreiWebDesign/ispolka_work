<?php

class Project extends Model
{
    protected $fillable = ['name', 'contractor_id'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'project_user_roles')
            ->withPivot('role')
            ->withTimestamps();
    }

    public function contractor()
    {
        return $this->belongsTo(User::class, 'contractor_id');
    }
}
