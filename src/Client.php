<?php

namespace InvoiceApi;

use InvoiceApi\Helpers\ArrayHelper;
use InvoiceApi\Repositories\AccountInfoRestRepository;
use InvoiceApi\Repositories\DocumentRestRepository;
use InvoiceApi\Transports\Transport;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

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
     * @var RequestInterface
     */
    protected $lastRequest;

    /**
     * @var ResponseInterface
     */
    protected $lastResponse;

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
     * @return RequestInterface
     */
    public function getLastRequest()
    {
        return $this->lastRequest;
    }

    /**
     * @return ResponseInterface
     */
    public function getLastResponse()
    {
        return $this->lastResponse;
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
        // add token to headers
        $options['headers']['Authorization'] = sprintf('Bearer %s', $this->bearerToken);

        $data = $this->rawRequest($method, $uri, $options);

        return ArrayHelper::getValue($data, 'data', []);
    }

    /**
     * @param string $method
     * @param string $uri
     * @param array  $options
     *
     * @return array
     * @throws \InvoiceApi\Exceptions\TransportException
     */
    public function rawRequest($method, $uri, array $options = [])
    {
        $this->lastRequest = $this->prepareRequest($method, $uri, $options);
        $this->lastResponse = $this->transport->send($this->lastRequest, $options);

        return json_decode($this->lastResponse->getBody(), true);
    }

    /**
     * @param string $method
     * @param string $uri
     * @param array  $options
     *
     * @return \Psr\Http\Message\RequestInterface
     */
    protected function prepareRequest($method, $uri, array $options = [])
    {
        return $this->transport->newRequest(
            $method,
            sprintf('%s/%s', $this->baseUri, $uri),
            ArrayHelper::getValue($options, 'headers', []),
            ArrayHelper::getValue($options, 'body')
        );
    }

    /**
     * @return DocumentRestRepository
     */
    public function documents()
    {
        return new DocumentRestRepository($this);
    }
}