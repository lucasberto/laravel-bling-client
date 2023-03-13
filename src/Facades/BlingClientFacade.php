<?php

namespace Lucasberto\LaravelBlingClient\Facades;

use Illuminate\Support\Facades\Facade;

class BlingClientFacade extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'blingclient';
    }
}
