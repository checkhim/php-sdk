<?php
require 'vendor/autoload.php';

use CheckHim\CheckHim;

$client = new CheckHim('ch_test_your_api_key');

try {
    $r = $client->verify('+5511984339000');
    echo "Valid: " . ($r['valid'] ? 'yes' : 'no') . " Carrier: " . $r['carrier'] . PHP_EOL;
} catch (Exception $e) {
    echo "Error: {$e->getMessage()}" . PHP_EOL;
}
