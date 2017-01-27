<?php

namespace InvoiceApi;

use InvoiceApi\Base\Model;
use InvoiceApi\Exceptions\TransportException;
use InvoiceApi\Models\Response;
use InvoiceApi\Repositories\AccountInfoRestRepository;
use InvoiceApi\Repositories\DocumentRestRepository;
use InvoiceApi\Transports\Transport;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

/**
 * Class Client
 *
 * @method RequestBuilder id($id)
 * @method RequestBuilder create(Model $model)
 * @method RequestBuilder update(Model $model)
 *
 * @method RequestBuilder accountInfo()
 * @method RequestBuilder documents()
 * @method RequestBuilder documentsImport()
 * @method RequestBuilder accurateAttributes()
 *
 * @package InvoiceApi
 */
class Client implements LoggerAwareInterface
{
    use LoggerAwareTrait;

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
     * Client constructor.
     *
     * @param LoggerInterface|null $logger
     */
    public function __construct(LoggerInterface $logger = null)
    {
        $this->logger = $logger ?: new NullLogger();
    }

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
     * Sets a logger.
     *
     * @param LoggerInterface $logger
     *
     * @return $this
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;

        return $this;
    }

//    /**
//     * @return AccountInfoRestRepository
//     */
//    public function accountInfo()
//    {
//        return new AccountInfoRestRepository($this);
//    }

//    /**
//     * @return DocumentRestRepository
//     */
//    public function documents()
//    {
//        return new DocumentRestRepository($this);
//    }

    /**
     * @param string $uri
     * @param array  $options
     *
     * @return Response
     * @throws \InvoiceApi\Exceptions\TransportException
     */
    public function get($uri, array $options = [])
    {
        return $this->request('GET', $uri, $options);
    }

    /**
     * @param string $method
     * @param string $uri
     * @param array  $options
     *
     * @return Response
     * @throws \InvoiceApi\Exceptions\TransportException
     */
    public function request($method, $uri, array $options = [])
    {
        return new Response($this->rawRequest($method, $uri, $options));
    }

    /**
     * @param string $method
     * @param string $uri
     * @param array  $options
     *
     * @return array
     * @throws TransportException
     */
    public function rawRequest($method, $uri, array $options = [])
    {
        if ($this->baseUri) {
            $uri = sprintf('%s%s', $this->baseUri, $uri);
        }

        if ($this->bearerToken) {
            $options['headers']['Authorization'] = sprintf('Bearer %s', $this->bearerToken);
        }

        $this->logger->debug(sprintf('Requesting %s with method %s.', $uri, $method), ['options' => $options]);

        try {
            $this->lastRequest = $this->transport->createRequest($method, $uri, $options);

            /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
            $this->lastResponse = $this->transport->send($this->lastRequest, $options);
        } catch (\Exception $e) {
            throw new TransportException($e->getMessage(), $e->getCode(), $e);
        }

        if ((int)floor($this->lastResponse->getStatusCode() / 100) !== 2) {
            $this->logger->emergency(sprintf('Cannot make request to uri %s with method %s.', $uri, $method), [
                'statusCode' => $this->lastResponse->getStatusCode(),
            ]);

            throw new TransportException($this->lastResponse->getReasonPhrase(), $this->lastResponse->getStatusCode());
        }

        $body = json_decode($this->lastResponse->getBody(), true);

        $this->logger->debug(sprintf('Response %s with method %s.', $uri, $method), ['body' => $body]);

        return $body;
    }

    /**
     * @param string $uri
     * @param array  $options
     *
     * @return Response
     * @throws \InvoiceApi\Exceptions\TransportException
     */
    public function post($uri, array $options = [])
    {
        return $this->request('POST', $uri, $options);
    }

    /**
     * @param string $name
     * @param array  $arguments
     *
     * @return RequestBuilder
     */
    public function __call($name, $arguments)
    {
        return (new RequestBuilder($this))->$name($arguments);
    }

    /**
     * @param string $uri
     * @param array  $options
     *
     * @return Response
     * @throws \InvoiceApi\Exceptions\TransportException
     */
    public function put($uri, array $options = [])
    {
        return $this->request('PUT', $uri, $options);
    }

    /**
     * @param string $uri
     * @param array  $options
     *
     * @return Response
     * @throws \InvoiceApi\Exceptions\TransportException
     */
    public function delete($uri, array $options = [])
    {
        return $this->request('DELETE', $uri, $options);
    }
}