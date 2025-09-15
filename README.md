# CheckHim PHP SDK

Official SDK for integrating with the CheckHim API (https://checkhim.tech) to verify if a phone number is active.

## Installation

Via Composer:

```
composer require checkhim/php
```

## Basic Usage

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

## Response Example

```json
{
  "carrier": "TIM",
  "valid": true
}
```

If the API returns an error, the response will be:

```json
{
  "error": "verification failed: Network is forbidden (code: 6)",
  "code": "REJECTED_NETWORK",
  "http_status": 400
}
```

## Documentation
- [API Docs](https://checkhim.tech)

## Contributing

Contributions are welcome! To contribute:

1. Fork this repository and create your branch from `main`.
2. Install dependencies with `composer install`.
3. Write clear, tested code and add/adjust tests in the `tests/` directory.
4. Run tests locally with:
   ```
   php vendor/bin/phpunit --testdox
   ```
5. Open a Pull Request with a clear description of your changes.

For bug reports or feature requests, please open an issue.

## License
MIT
