<?php

namespace InvoiceApi\Repositories;

use InvoiceApi\Client;

/**
 * Class Repository
 *
 * @package InvoiceApi\Repositories
 */
abstract class RestRepository implements Repository
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * Repository constructor.
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @return Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param Client $client
     *
     * @return $this
     */
    public function setClient($client)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * return array
     *
     * @throws \InvoiceApi\Exceptions\TransportException
     */
    public function getList()
    {
        $modelClass = $this->getModelClass();

        return array_map(function ($item) use ($modelClass) {
            return $modelClass($item);
        }, $this->client->request('GET', $this->getUri()));
    }

    /**
     * @return string
     */
    public abstract function getModelClass();

    /**
     * @return string
     */
    public abstract function getUri();

    /**
     * @return mixed
     *
     * @throws \InvoiceApi\Exceptions\TransportException
     */
    public function get()
    {
        $modelClass = $this->getModelClass();

        return new $modelClass($this->client->request('GET', $this->getUri()));
    }

    /**
     * @param mixed $id
     *
     * @return mixed
     *
     * @throws \InvoiceApi\Exceptions\TransportException
     */
    public function getById($id)
    {
        $modelClass = $this->getModelClass();

        return new $modelClass($this->client->request('GET', sprintf('%s/%s', $this->getUri(), $id)));
    }
}