<?php

namespace InvoiceApi\Transports;

use InvoiceApi\Exceptions\TransportException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;

/**
 * Interface Transport
 *
 * @package InvoiceApi
 */
interface Transport
{
    /**
     * Send an HTTP request.
     *
     * @param RequestInterface $request Request to send
     * @param array            $options Request options to apply to the given
     *                                  request and to the transfer.
     *
     * @return ResponseInterface
     * @throws TransportException
     */
    public function send(RequestInterface $request, array $options = []);

    /**
     * Create and send an HTTP request.
     *
     * Use an absolute path to override the base path of the client, or a
     * relative path to append to the base path of the client. The URL can
     * contain the query string as well.
     *
     * @param string              $method HTTP method.
     * @param string|UriInterface $uri URI object or string.
     * @param array               $options Request options to apply.
     *
     * @return ResponseInterface
     * @throws TransportException
     */
    public function request($method, $uri, array $options = []);
}