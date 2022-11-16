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
    private $postXML = '';

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
                if ($response->successful() && isset($response['retorno'][$this->returnIndex])) {
                    return $response['retorno'][$this->returnIndex];
                } else {
                    //TODO: Log the error
                    return false;
                }
            } catch (\Throwable $e) {
                // TODO: Log the error
                return false;
            }
        }
    }

    private function generateProductLinkXML($id)
    {
        $xml = '
        <?xml version="1.0" encoding="UTF-8"?>
        <produtosLoja>
            <produtoLoja>
               <idLojaVirtual>' . $id . '</idLojaVirtual>
               <preco>
                   <preco>9999</preco>
                   <precoPromocional>9999</precoPromocional>
               </preco>               
           </produtoLoja>
        </produtosLoja>
        ';
        return $xml;
    }

    private function generateProductXML($data)
    {
        $xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
        <produto>
           <codigo>{$data['sku']}</codigo>
           <descricao></descricao>
           <peso_bruto>{$data['weight']}</peso_bruto>
           <peso_liq>{$data['weight']}</peso_liq>
           <marca>{$data['brand']}</marca>
           <gtin>{$data['ean']}</gtin>
           <localizacao>{$data['location']}</localizacao>
         </produto>";

        return $xml;
    }

    public function postRequestXML()
    {
        $reqUrl = "{$this->baseUrl}{$this->actionUrl}";
        try {
            //$response = Http::retry(3, 300)->get($reqUrl, $params)->throw();
            $response = Http::retry(3, 300)->asForm()->post($reqUrl, [
                'apikey' => $this->apiKey,
                'xml' => rawurlencode($this->postXML)
            ]);

            //$resp_array = $response->json();

            if ($response->successful() && isset($response['retorno'][$this->returnIndex])) {
                return $response['retorno'][$this->returnIndex];
            } else {
                //TODO: Log the error
                return false;
            }
        } catch (\Throwable $e) {
            // TODO: Log the error
            return false;
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

    public function updateLink($sku, $id, $store_id)
    {
        $this->actionUrl = "produtoLoja/{$store_id}/{$sku}/json/";
        $this->actionType = 'update_link';
        $this->returnIndex = 'produtosLoja';
        $this->postXML = $this->generateProductLinkXML($id);

        return $this;
    }

    public function updateProduct($data)
    {
        $this->actionUrl = "produto/{$data['sku']}/json/";
        $this->actionType = 'update_product';
        $this->returnIndex = 'produtos';
        $this->postXML = $this->generateProductXML($data);

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
        } else if ($this->actionType == 'update_link') {
            $this->result = $this->postRequestXML();
        } else if ($this->actionType == 'update_product') {
            $this->result = $this->postRequestXML();
        }


        return $this->result;
    }
}
