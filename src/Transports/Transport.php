<?php

namespace InvoiceApi\Transports;

use GuzzleHttp\ClientInterface;
use Psr\Http\Message\RequestInterface;

/**
 * Interface Transport
 *
 * @package InvoiceApi\Transports
 */
interface Transport extends ClientInterface
{
    /**
     * @param string $method
     * @param string $url
     * @param array  $options
     *
     * @return RequestInterface
     */
    public function createRequest($method, $url, array $options = []);
}