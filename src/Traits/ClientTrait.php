<?php

namespace InvoiceApi\Traits;

use InvoiceApi\Client;

/**
 * Class ClientTrait
 *
 * @package InvoiceApi\Traits
 */
trait ClientTrait
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * ClientTrait constructor.
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }
}