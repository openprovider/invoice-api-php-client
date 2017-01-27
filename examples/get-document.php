<?php

use InvoiceApi\Client;
use InvoiceApi\Models\Document;
use InvoiceApi\Transports\DefaultTransport;

require_once __DIR__ . '/../vendor/autoload.php';

$client = Client::build()
    ->setTransport(new DefaultTransport())
    ->setBaseUri('https://invconv-stage.openprovider.nl/api/v1')
    ->setBearerToken('123')
    ->getClient();

$response = $client->documents()->id(1)->get();

// as array
var_dump($response->getData());

// as model
var_dump($response->toModel(Document::class));
