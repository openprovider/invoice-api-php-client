<?php
namespace Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

use Codeception\Util\Stub;
use InvoiceApi\Transports\Transport;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class Unit extends \Codeception\Module
{
    /**
     * @param array $data
     *
     * @param int   $statusCode
     *
     * @return object|ResponseInterface
     */
    public function stubResponse(array $data, $statusCode = 200)
    {
        return Stub::makeEmpty(ResponseInterface::class, [
            'getBody' => function () use ($data) {
                return json_encode($data);
            },
            'getStatusCode' => function () use ($statusCode) {
                return $statusCode;
            },
        ]);
    }

    /**
     * @param ResponseInterface $response
     *
     * @return Transport|object
     * @throws \RuntimeException
     */
    public function stubTransportWithResponse(ResponseInterface $response)
    {
        return Stub::makeEmpty(Transport::class, [
            'send' => function () use ($response) {
                return $response;
            },
            'request' => function () use ($response) {
                return $response;
            },
            'createRequest' => function () {
                return Stub::makeEmpty(RequestInterface::class);
            },
        ]);
    }
}
