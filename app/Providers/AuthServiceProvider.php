<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('is_admin', function ($user) {
            return $user->profile=='admin'
                        ? true
                        : false;
        });

        Gate::define('is_student', function ($user) {
            return $user->profile=='student'
                        ? true
                        : false;
        });

        Gate::define('is_user', function ($user) {
            return $user->profile=='user'
                        ? true
                        : false;
        });

        Gate::define('is_professor', function ($user) {
            return $user->profile=='professor'
                        ? true
                        : false;
        });
    }
}
