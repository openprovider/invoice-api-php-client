<?php
namespace Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

use Codeception\Util\Stub;
use InvoiceApi\Transports\Transport;
use Psr\Http\Message\ResponseInterface;

class Unit extends \Codeception\Module
{
    /**
     * @param array $data
     *
     * @return ResponseInterface|object
     * @throws \RuntimeException
     */
    public function stubResponse(array $data)
    {
        return Stub::makeEmpty(ResponseInterface::class, [
            'getBody' => function () use ($data) {
                return json_encode($data);
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
        ]);
    }
}
