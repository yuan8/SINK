<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

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
        
        //
        Gate::define('alive', 'App\Policies\UserPolicy@isAlive');
        Gate::define('accessPusat', 'App\Policies\UserPolicy@accessPusat');
        Gate::define('accessAdmin', 'App\Policies\UserPolicy@accessAdmin');


    }
}
