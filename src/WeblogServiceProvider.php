<?php

namespace Georgesdoe\Weblog;

use Illuminate\Support\ServiceProvider;

class WeblogServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes.php');
        $this->loadViewsFrom(__DIR__.'/views', 'weblog');
    }

    public function register()
    {
        //
    }
}
