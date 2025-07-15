<?php

namespace App\Policies;

use App\Models\User;

class rojectolicy
{
    public function create(User $user)
{
    return $user->role === 'подрядчик';
}
    public function __construct()
    {
        //
    }
}
