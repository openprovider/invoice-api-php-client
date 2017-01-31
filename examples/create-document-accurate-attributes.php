<?php

use InvoiceApi\Client;
use InvoiceApi\Models\AccurateAttribute;
use InvoiceApi\Transports\DefaultTransport;

require_once __DIR__ . '/../vendor/autoload.php';

$client = Client::build()
    ->setBaseUri('https://invconv-stage.openprovider.nl/api/v1')
    ->setBearerToken('')
    ->getClient();

$response = $client->documents()->id(1)->accurateAttributes()->post([
    'json' => [
        [
            'name' => 'test-attribute',
            'value' => '1',
        ],
    ],
]);

// as array
var_dump($response->getData());

// as model list
var_dump($response->toModelList(AccurateAttribute::class));
