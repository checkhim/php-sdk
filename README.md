# CheckHim PHP SDK

SDK oficial para integração com a API CheckHim (https://checkhim.tech) para verificação de números ativos.

## Instalação

Via Composer:

```
composer require checkhim/php
```

## Uso Básico

```php
require 'vendor/autoload.php';

use CheckHim\CheckHim;

$client = new CheckHim('ch_test_your_api_key');

try {
    $r = $client->verify('+5511984339000');
    echo "Valid: " . ($r['valid'] ? 'yes' : 'no') . " Carrier: " . $r['carrier'] . PHP_EOL;
} catch (Exception $e) {
    echo "Error: {$e->getMessage()}" . PHP_EOL;
}
```

## Resposta

```json
{
  "carrier": "TIM",
  "valid": true
}
```

## Documentação
- [API Docs](https://checkhim.tech)

## Licença
MIT
