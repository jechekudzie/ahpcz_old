<?php

namespace App\Providers;

use App\Policies\AdminPolicy;
use Illuminate\Contracts\Auth\Access\Gate;
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


    public function boot(Gate $gate, Gate $admin)
    {
        $this->registerPolicies();

        /*$gate->before(function ($user) {
            return $user->role_id == 1;
        });*/


        foreach (get_class_methods(new \App\Policies\AdminPolicy) as $method) {
            $admin->define($method, "App\Policies\AdminPolicy@{$method}");
        }


    }

}
