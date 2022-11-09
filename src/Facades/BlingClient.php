<?php

namespace Lucasberto\LaravelBlingClient\Facades;

use Illuminate\Support\Facades\Facade;

class BlingClient extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'blingclient';
    }
}
