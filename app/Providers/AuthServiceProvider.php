<?php

namespace App\Providers;

use App\Models\BusinessCategory;
use App\Models\Destination;
use App\Models\Employee;
use App\Models\RegisteredEmail;
use App\Policies\BusinessCategoryPolicy;
use App\Policies\DestinationPolicy;
use App\Policies\EmployeePolicy;
use App\Policies\RegisteredEmailPolicy;
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
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        Employee::class => EmployeePolicy::class,
        Destination::class => DestinationPolicy::class,
        BusinessCategory::class => BusinessCategoryPolicy::class,
        RegisteredEmail::class => RegisteredEmailPolicy::class,
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
    }
}
