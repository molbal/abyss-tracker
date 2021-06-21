<?php

namespace App\Providers;

use App\Http\Controllers\Auth\AuthController;
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

        Gate::define('viewWebLogs', function ($user = null) {
//            dd(session()->all());
            return AuthController::isItMe(config('tracker.veetor.id', 93940047));
        });
    }
}
