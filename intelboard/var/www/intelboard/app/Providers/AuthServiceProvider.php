<?php

namespace App\Providers;

use App\Models\Broker;
use App\Models\Driver;
use App\Policies\BrokerPolicy;
use App\Policies\DriverPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Driver::class => DriverPolicy::class,
        Broker::class => BrokerPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        //
    }
}
