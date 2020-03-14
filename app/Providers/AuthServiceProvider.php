<?php

namespace App\Providers;

use Laravel\Passport\Passport;
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

        Passport::routes();

        Passport::tokensExpireIn(now()->addDays(100));

        Passport::refreshTokensExpireIn(now()->addDays(100));

        Passport::personalAccessTokensExpireIn(now()->addMonths(12));

        Passport::enableImplicitGrant();

        Passport::personalAccessClientId('client-id');

        Passport::routes();

        Passport::cookie('custom_name');
    }
}
