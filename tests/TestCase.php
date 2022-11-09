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
        $app['config']->set('test_bling_token', '7d6265da915c702875a58634656af0cfe4cffabf4c2ad58637c174475f976920fd59c414');
        $app['config']->set('test_store_code', '204153875');
        $app['config']->set('test_sku', '807201');
    }
}
