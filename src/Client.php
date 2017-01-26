<?php

namespace InvoiceApi;

use InvoiceApi\Helpers\ArrayHelper;
use InvoiceApi\Repositories\AccountInfoRestRepository;
use InvoiceApi\Repositories\DocumentRestRepository;
use InvoiceApi\Transports\Transport;

/**
 * Class Client
 *
 * @package InvoiceApi
 */
class Client
{
    /**
     * @var Transport
     */
    protected $transport;

    /**
     * @var string
     */
    protected $baseUri;

    /**
     * @var string
     */
    protected $bearerToken;

    /**
     * @return ClientBuilder
     */
    public static function build()
    {
        return ClientBuilder::build();
    }

    /**
     * @return Transport
     */
    public function getTransport()
    {
        return $this->transport;
    }

    /**
     * @param Transport $transport
     *
     * @return $this
     */
    public function setTransport(Transport $transport)
    {
        $this->transport = $transport;

        return $this;
    }

    /**
     * @return string
     */
    public function getBaseUri()
    {
        return $this->baseUri;
    }

    /**
     * @param string $baseUri
     *
     * @return $this
     */
    public function setBaseUri($baseUri)
    {
        $this->baseUri = $baseUri;

        return $this;
    }

    /**
     * @return string
     */
    public function getBearerToken()
    {
        return $this->bearerToken;
    }

    /**
     * @param string $bearerToken
     *
     * @return $this
     */
    public function setBearerToken($bearerToken)
    {
        $this->bearerToken = $bearerToken;

        return $this;
    }

    /**
     * @return AccountInfoRestRepository
     */
    public function accountInfo()
    {
        return new AccountInfoRestRepository($this);
    }

    /**
     * @param string $method
     * @param string $uri
     * @param array  $options
     *
     * @return array
     * @throws \InvoiceApi\Exceptions\TransportException
     */
    public function request($method, $uri, array $options = [])
    {
        $response = $this->transport->request($method, sprintf('%s/%s', $this->baseUri, $uri), $options);

        $data = json_decode($response->getBody(), true);

        return ArrayHelper::getValue($data, 'data');
    }

    /**
     * @return DocumentRestRepository
     */
    public function documents()
    {
        return new DocumentRestRepository($this);
    }
}