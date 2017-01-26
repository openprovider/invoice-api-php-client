<?php

namespace InvoiceApi;

use InvoiceApi\Exceptions\BuilderException;
use InvoiceApi\Transports\Transport;

/**
 * Class ClientBuilder
 *
 * @method $this setTransport(Transport $transport)
 * @method $this setBaseUri(string $baseUri)
 * @method $this setBearerToken(string $baseUri)
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