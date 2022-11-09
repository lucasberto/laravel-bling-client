<?php

namespace Lucasberto\LaravelBlingClient\Tests\Feature;

use Lucasberto\LaravelBlingClient\Tests\TestCase;
use Lucasberto\LaravelBlingClient\Facades\BlingClient;

class ProductsTest extends TestCase
{
    public function test_products_fetch()
    {
        $result = BlingClient::withToken(config('test_bling_token'))->products()->fetch();
        $this->assertTrue(count($result) > 0);
    }

    public function test_products_fetch_by_store()
    {
        $result = BlingClient::withToken(config('test_bling_token'))->byStore(config('test_store_code'))->products()->fetch();
        $this->assertTrue(count($result) > 0);
    }

    public function test_product_fetch()
    {
        $result = BlingClient::withToken(config('test_bling_token'))->product(config('test_sku'))->fetch();
        if ($result) {
            $this->assertTrue(count($result) > 0);
        } else $this->assertTrue(false);
    }

    public function test_product_fetch_by_store()
    {
        $result = BlingClient::withToken(config('test_bling_token'))->product(config('test_sku'))->byStore(config('test_store_code'))->fetch();
        if ($result) {
            $this->assertTrue(count($result) > 0);
        } else $this->assertTrue(false);
    }
}
