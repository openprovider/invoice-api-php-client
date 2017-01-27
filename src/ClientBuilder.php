<?php

namespace InvoiceApi;

use GuzzleHttp\ClientInterface;
use InvoiceApi\Exceptions\BuilderException;
use Psr\Log\LoggerInterface;

/**
 * Class ClientBuilder
 *
 * @method $this setTransport(ClientInterface $transport)
 * @method $this setBaseUri(string $baseUri)
 * @method $this setBearerToken(string $baseUri)
 * @method $this setLogger(LoggerInterface $logger)
 *
 * @package InvoiceConverter
 */
class ClientBuilder
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * ClientBuilder constructor.
     */
    protected function __construct()
    {
        $this->client = new Client();
    }

    /**
     * @return static
     */
    public static function build()
    {
        return new static();
    }

    /**
     * @param $name
     * @param $arguments
     *
     * @return $this
     * @throws \InvoiceApi\Exceptions\BuilderException
     */
    public function __call($name, $arguments)
    {
        if (!method_exists($this->client, $name)) {
            throw new BuilderException(sprintf('Method %s is undefined', $name));
        }

        call_user_func_array([$this->client, $name], $arguments);

        return $this;
    }

    /**
     * @return Client
     */
    public function getClient()
    {
        return $this->client;
    }
}