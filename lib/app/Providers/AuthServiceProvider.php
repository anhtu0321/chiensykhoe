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
        
        // gate tài khoản
        Gate::define('view_user', function($user){
            return $user->ktraphanquyen('view_user');
        });
        Gate::define('add_user', function($user){
            return $user->ktraphanquyen('add_user');
        });
        Gate::define('edit_user', function($user){
            return $user->ktraphanquyen('edit_user');
        });
        Gate::define('delete_user', function($user){
            return $user->ktraphanquyen('delete_user');
        });
        // gate role
        Gate::define('view_role', function($user){
            return $user->ktraphanquyen('view_role');
        });
        Gate::define('add_role', function($user){
            return $user->ktraphanquyen('add_role');
        });
        Gate::define('edit_role', function($user){
            return $user->ktraphanquyen('edit_role');
        });
        Gate::define('delete_role', function($user){
            return $user->ktraphanquyen('delete_role');
        });
        // gate permission
        Gate::define('view_permission', function($user){
            return $user->ktraphanquyen('view_permission');
        });
        Gate::define('add_permission', function($user){
            return $user->ktraphanquyen('add_permission');
        });
        Gate::define('edit_permission', function($user){
            return $user->ktraphanquyen('edit_permission');
        });
        Gate::define('delete_permission', function($user){
            return $user->ktraphanquyen('delete_permission');
        });
    }
}

