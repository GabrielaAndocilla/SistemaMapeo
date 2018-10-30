<?php

namespace Udla\Providers;

use Illuminate\Support\ServiceProvider;
use Udla\Model\Periodo;

class PeriodoActualServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
      // $this->app['periodo'] = $this->app->share(function($app)
      // {
      //   return new \Udla\Factory\PeriodoFactory(new Periodo);
      // });

      $this->app->singleton('periodo', function ($app) {
        return new \Udla\Factory\PeriodoFactory(new Periodo);
      });

// Shortcut so developers don't need to add an Alias in app/config/app.php
      // $this->app->booting(function()
      // {
      //   $loader = \Illuminate\Foundation\AliasLoader::getInstance();
      //   $loader->alias('periodo', 'Udla\Facades\ActualPeriodo');
      // });
    }
}
