<?php

namespace Udla\Providers;

use Illuminate\Support\ServiceProvider;
use Udla\Helpers\UtilsHelper;

class UtilsServiceProvider extends ServiceProvider
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
      // $this->app['utils'] = $this->app->share(function($app)
      // {
      //   return new \Udla\Helpers\UtilsHelper;
      // });

      $this->app->singleton('utils', function ($app) {
        return new \Udla\Helpers\UtilsHelper;
      });
    }
}
