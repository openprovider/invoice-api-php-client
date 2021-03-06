<?php

use InvoiceApi\Client;
use InvoiceApi\Helpers\ArrayHelper;

require_once __DIR__ . '/../vendor/autoload.php';

$client = Client::build()
    ->setBaseUri('https://invoice-api.com/api/v1')
    ->setBearerToken('')
    ->getClient();

$response = $client->documentsImport()->post([
    'multipart' => [
        [
            'name' => 'file',
            'contents' => fopen(__DIR__ . '/../tests/_data/test.pdf', 'r'),
        ],
    ],
]);

var_dump($response->getData());

// then get created document
var_dump($client->documents()->id(ArrayHelper::getValue($response->getData(), 'items.0'))->get()->getData());
