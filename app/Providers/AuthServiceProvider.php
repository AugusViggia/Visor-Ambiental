<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\Point;
use App\Policies\PointPolicy;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Point::class => PointPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

         /* define a admin user role */
         Gate::define('isAdmin', function ($user) {
            return $user->hasRole('ADM');
         });

         /* define a user role */
         Gate::define('isUser', function ($user) {
            return $user->hasRole('USI');
         });
    }
}
