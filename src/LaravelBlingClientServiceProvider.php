<?php

namespace Lucasberto\LaravelBlingClient;

use Illuminate\Support\ServiceProvider;

class LaravelBlingClientServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('blingclient', function ($app) {
            return new BlingClient;
        });
    }

    public function boot()
    {
    }
}
