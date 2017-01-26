<?php

namespace InvoiceApi\Transports;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use InvoiceApi\Exceptions\TransportException;
use Psr\Http\Message\RequestInterface;

/**
 * Class DefaultTransport
 *
 * @package InvoiceApi
 */
class DefaultTransport extends Client implements Transport
{
    /**
     * @param RequestInterface $request
     * @param array            $options
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws TransportException
     */
    public function send(RequestInterface $request, array $options = [])
    {
        try {
            return parent::send($request, $options);
        } catch (GuzzleException $e) {
            throw new TransportException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @param string $method
     * @param string $uri
     * @param array  $options
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws TransportException
     */
    public function request($method, $uri = '', array $options = [])
    {
        try {
            return parent::request($method, $uri, $options);
        } catch (GuzzleException $e) {
            throw new TransportException($e->getMessage(), $e->getCode(), $e);
        }
    }
}