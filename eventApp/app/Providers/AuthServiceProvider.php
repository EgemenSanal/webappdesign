<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;



class AuthServiceProvider extends ServiceProvider
{
    /**
     * Uygulamanın herhangi bir policy map'i.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Herhangi bir authentication/authorization servisi kaydeder.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Passport rotalarını kaydedin
        Passport::routes();
        Passport::useClientModel(App\Models\Member::class);
    }
}
