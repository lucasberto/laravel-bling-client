
> [!WARNING]  
> Esse pacote foi descontinuado, pois utiliza a versão 2 da API do Bling, que foi descontinuada para dar lugar à versão 3.


## **Este pacote implementa a comunicação com a API do Bling ERP.**

_Pacote ainda em desenvolvimento. Nem todas as funcionalidades da API estão implementadas._

### Requisitos

    - Laravel >= 8.x

### Instalação

via Packagist (composer):

```
composer require lucasberto/laravel-bling-client
```

### Utilização

A Facade _Lucasberto\LaravelBlingClient\Facades\BlingClient_ deverá ser importada automaticamente pelo Autoloader, porém, se encontrar algum problema (classe BlingClient não encontrada), você poderá importar manualmente a Facade:

```
use Lucasberto\LaravelBlingClient\Facades\BlingClient;

```

Este pacote utiliza interface fluente (Fluent API / Method Chaining) para realizar as operações.

**Exemplo 1: Listar todos os produtos**

```
BlingClient::withToken('SEU_TOKEN')->products()->fetch();
```

**Exemplo 2: Listar todos os produtos para uma loja específica**

```
BlingClient::withToken('SEU_TOKEN')->products()->byStore('CÓDIGO_LOJA')->fetch();
```

**Exemplo 3: Trazer informações de um produto específico**

```
BlingClient::withToken('SEU_TOKEN')->product('SKU_DO_PRODUTO')->fetch();
```

### Métodos disponíveis

| Método                                           | Descrição                                                                                                                                                                                          |
| ------------------------------------------------ | -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| withToken(_'SEU_TOKEN'_)                         | **Obrigatório.** Especifica o token da API Bling a ser usado na requisição.                                                                                                                        |
| products()                                       | Lista todos os produtos. Pode ser associado a _byStore()_ para trazer informações específicas de uma loja.                                                                                         |
| product(_'SKU'_)                                 | Traz informações de um produto específico identificado pelo número _SKU_ do Bling. Pode ser associado a _byStore()_.                                                                               |
| updateLink(_'SKU'_, _'ID-INTERNO'_, _'ID-LOJA'_) | Atualiza vínculo entre _SKU_ e _ID-INTERNO_ no Bling para a loja _ID-LOJA_.                                                                                                                        |
| updateProduct(Array _dados_)                     | Atualiza dados de um produto no Bling. A informação _dados['sku']_ é obrigatória. Campos possíveis: _weight_(peso bruto e líquido), _brand_(marca), _ean_(EAN), _location_(Localização no estoque) |
| byStore(_'CODIGO-LOJA'_)                         | Especifica a loja para a qual a requisição está sendo feita. O _CODIGO-LOJA_ pode ser encontrado nas configurações de Integração no Bling.                                                         |

### Testando

Caso queira executar os testes no pacote, será necessário preencher as informações de teste no arquivo _.env.test_ e, em seguida, renomeá-lo para _.env_.
