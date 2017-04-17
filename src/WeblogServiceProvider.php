<?php

namespace Georgesdoe\Weblog;

use Illuminate\Support\ServiceProvider;

class WeblogServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes.php');
        $this->loadViewsFrom(__DIR__.'/views', 'weblog');
        $this->publishes([
            __DIR__.'/public' =>public_path('vendor/weblog'),
        ]);
        $this->publishes([
            __DIR__.'/views' => resource_path('views/vendor/weblog'),
        ],'views');
    }

    public function register()
    {
        //
    }
}
