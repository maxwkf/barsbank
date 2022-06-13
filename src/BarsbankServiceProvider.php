<?php

namespace Maxwkf\Barsbank;

use Illuminate\Support\ServiceProvider;

class BarsbankServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'barsbank');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            // php artisan vendor:publish --provider="Maxwkf\Barsbank\BarsbankServiceProvider" --tag="config"

            $this->publishes([
              __DIR__.'/../config/config.php' => config_path('barsbank.php'),
            ], 'config');
        
          }
    }
}
