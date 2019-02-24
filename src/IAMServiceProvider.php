<?php

namespace Nddcoder\PassportIAM;

use Auth;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Support\ServiceProvider;
use Nddcoder\PassportIAM\Services\IAMGuard;
use Nddcoder\PassportIAM\Services\IAMService;
use Nddcoder\PassportIAM\Services\IAMServiceInterface;
use Nddcoder\PassportIAM\Services\TokenToUserProvider;

class IAMServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/passport-iam.php' => config_path('passport-iam.php'),
            ], 'config');
        }

        $this->publishes([
            __DIR__.'/../config/passport-iam.php' => config_path('passport-iam.php'),
        ], 'config');


        $this->mergeConfigFrom(__DIR__.'/../config/passport-iam.php', 'passport-iam');

        Auth::extend('access_token', function ($app, $name, array $config) {
            $request = app('request');
            $userProvider = Auth::createUserProvider($config['provider']);
            return new IAMGuard($userProvider, $request, $config);
        });

        Auth::provider('token', function($app, array $config) {
            return new TokenToUserProvider(app(Hasher::class), $config['model']);
        });
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(IAMServiceInterface::class, IAMService::class);
    }
}
