<?php

namespace Lucasberto\LaravelBlingClient;

use Illuminate\Support\Facades\Http;

class BlingClient
{
    private $baseUrl = 'https://bling.com.br/Api/v2/';
    private $apiKey = null;
    private $actionUrl = '';
    private $actionType = '';
    private $returnIndex = null;
    private $result = [];
    private $storeCode = null;

    public function __construct()
    {
    }

    private function fetchUsingGet($hasPages = false)
    {
        $params = [
            'apikey' => $this->apiKey,
            'estoque' => 'S',
            'filters' => 'situacao[A]',
        ];

        if ($this->storeCode) $params['loja'] = $this->storeCode;


        if ($hasPages) {
            $result = [];
            $page = 1;
            do {
                $reqUrl = sprintf("{$this->baseUrl}{$this->actionUrl}", $page);
                try {
                    $ret = Http::retry(3, 300)->get($reqUrl, $params)->throw();
                } catch (\Throwable $e) {
                    // TODO: Log the error
                }

                if (!isset($ret['retorno']['erros']) && isset($ret['retorno'][$this->returnIndex])) {
                    $result = array_merge($result, $ret['retorno'][$this->returnIndex]);
                }
                $page++;
            } while (!isset($ret['retorno']['erros']) && isset($ret['retorno'][$this->returnIndex]));
            return $result;
        } else {
            $reqUrl = "{$this->baseUrl}{$this->actionUrl}";
            try {
                $response = Http::retry(3, 300)->get($reqUrl, $params)->throw();
            } catch (\Throwable $e) {
                // TODO: Log the error
            }
            if ($response->successful() && isset($response['retorno'][$this->returnIndex])) {
                return $response['retorno'][$this->returnIndex];
            } else {
                //TODO: Log the error
                return false;
            }
        }
    }

    public function withToken($token)
    {
        $this->apiKey = $token;
        return $this;
    }

    public function products()
    {
        $this->actionUrl = 'produtos/page=%s/json/';
        $this->actionType = 'produtos';
        $this->returnIndex = 'produtos';
        return $this;
    }

    public function product($sku)
    {
        $this->actionUrl = "produto/{$sku}/json/";
        $this->actionType = 'produto';
        $this->returnIndex = 'produtos';
        return $this;
    }

    public function byStore($storeCode)
    {
        $this->storeCode = $storeCode;
        return $this;
    }

    public function fetch()
    {
        if ($this->actionType == 'produtos') {
            $this->result = $this->fetchUsingGet(true);
        } else if ($this->actionType == 'produto') {
            $this->result = $this->fetchUsingGet(false);
        }


        return $this->result;
    }
}
