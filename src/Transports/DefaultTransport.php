<?php

namespace InvoiceApi\Transports;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use InvoiceApi\Helpers\ArrayHelper;
use Psr\Http\Message\RequestInterface;

/**
 * Class DefaultTransport
 *
 * @package InvoiceApi\Transports
 */
class DefaultTransport extends Client implements Transport
{
    /**
     * @param string $method
     * @param string $url
     * @param array  $options
     *
     * @return RequestInterface
     */
    public function createRequest($method, $url, array $options = [])
    {
        return new Request(
            $method,
            $url,
            ArrayHelper::getValue($options, 'headers', []),
            ArrayHelper::getValue($options, 'body')
        );
    }
}