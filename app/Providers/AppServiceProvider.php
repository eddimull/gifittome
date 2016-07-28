<?php namespace App\Providers;


use Auth;
use Config;
use App;
use Illuminate\Support\ServiceProvider;
use App\Extensions\AuthExtension;
use App\Providers\CustomUserProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Auth::extend('GuardExtension', function()
        {
            $model = Config::get('auth.model');
            $provider = new CustomUserProvider(App::make('hash'), $model);
            return new AuthExtension($provider, App::make('session.store'));
        });

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'Illuminate\Contracts\Auth\Registrar',
            'App\Services\Registrar'
        );
    }
}
