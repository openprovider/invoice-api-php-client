<?php

use InvoiceApi\Client;
use InvoiceApi\Helpers\ArrayHelper;
use InvoiceApi\Transports\DefaultTransport;

require_once __DIR__ . '/../vendor/autoload.php';

$client = Client::build()
    ->setTransport(new DefaultTransport())
    ->setBaseUri('https://invconv-stage.openprovider.nl/api/v1')
    ->setBearerToken('123')
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
