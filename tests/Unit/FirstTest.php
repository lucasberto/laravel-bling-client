<?php

namespace Lucasberto\LaravelBlingClient\Tests\Unit;

use Lucasberto\LaravelBlingClient\LaravelBlingClientServiceProvider;
use Lucasberto\LaravelBlingClient\Tests\TestCase;
use Lucasberto\LaravelBlingClient\Facades\BlingClient;

class FirstTest extends \Orchestra\Testbench\TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        // additional setup
    }

    protected function getPackageProviders($app)
    {
        return [
            LaravelBlingClientServiceProvider::class,
        ];
    }


    public function test_first_test()
    {

        $this->assertTrue(true);
    }
}
