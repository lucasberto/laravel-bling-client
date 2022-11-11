<?php

namespace Lucasberto\LaravelBlingClient\Tests;

use Lucasberto\LaravelBlingClient\LaravelBlingClientServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [
            LaravelBlingClientServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
    }
}
