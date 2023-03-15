<?php

namespace Lucasberto\LaravelBlingClient\Tests\Feature;

use Lucasberto\LaravelBlingClient\Tests\TestCase;
use Lucasberto\LaravelBlingClient\Facades\BlingClient;
use Illuminate\Support\Facades\Http;


class ProductsTest extends TestCase
{
    public function test_products_fetch()
    {
        $url = "bling.com.br/Api/v2/produtos/*";
        $ret = ['erros' => []];
        Http::fake([$url => Http::response([
            'retorno' => $ret
        ], 200, ['Headers'])]);


        $result = BlingClient::withToken(env('TEST_BLING_API_KEY'))->products()->fetch();
        $this->assertTrue(is_array($result));
    }

    public function test_products_fetch_by_store()
    {
        $url = "bling.com.br/Api/v2/produtos/*";
        $ret = ['erros' => []];
        Http::fake([$url => Http::response([
            'retorno' => $ret
        ], 200, ['Headers'])]);

        $result = BlingClient::withToken(env('TEST_BLING_API_KEY'))->byStore(env('TEST_STORE_CODE'))->products()->fetch();
        $this->assertTrue(is_array($result));
    }

    public function test_product_fetch()
    {
        $url = "bling.com.br/Api/v2/produto/" . env('TEST_SKU') . "/*";
        Http::fake([$url => Http::response([
            'retorno' => [
                'produtos' => 'TEST_OK'
            ]
        ], 200, ['Headers'])]);

        $result = BlingClient::withToken(env('TEST_BLING_API_KEY'))->product(env('TEST_SKU'))->fetch();
        $this->assertTrue($result && $result == 'TEST_OK');
    }

    public function test_product_fetch_by_store()
    {
        $url = "bling.com.br/Api/v2/produto/" . env('TEST_SKU') . "/*";
        Http::fake([$url => Http::response([
            'retorno' => [
                'produtos' => 'TEST_OK'
            ]
        ], 200, ['Headers'])]);

        $result = BlingClient::withToken(env('TEST_BLING_API_KEY'))->product(env('TEST_SKU'))->byStore(env('TEST_STORE_CODE'))->fetch();
        $this->assertTrue($result && $result == 'TEST_OK');
    }

    public function test_product_update_link()
    {
        $url = "bling.com.br/Api/v2/produtoLoja/" . env('TEST_STORE_CODE') . "/" . env('TEST_SKU') . "/*";
        Http::fake([$url => Http::response([
            'retorno' => [
                'produtosLoja' => 'TEST_OK'
            ]
        ], 200, ['Headers'])]);

        $result = BlingClient::withToken(env('TEST_BLING_API_KEY'))->updateLink(env('TEST_SKU'), 15, env('TEST_STORE_CODE'))->fetch();

        $this->assertTrue($result && $result == 'TEST_OK');
    }
}
