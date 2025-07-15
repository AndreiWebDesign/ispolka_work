<?php

namespace App\Providers;

use App\Models\Project;
use App\Policies\ProjectPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Project::class => ProjectPolicy::class,
    ];

    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->registerPolicies(); // 🔥 Обязательно вызвать!

        Gate::define('create-project', function (User $user) {
            \Log::info("Gate проверка: {$user->name} с ролью {$user->role}");
            return $user->role === 'подрядчик';
        });
    }
}
