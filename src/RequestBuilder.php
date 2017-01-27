<?php

namespace InvoiceApi;

use InvoiceApi\Base\Model;
use InvoiceApi\Helpers\ArrayHelper;
use InvoiceApi\Helpers\Inflector;
use InvoiceApi\Models\Response;
use InvoiceApi\Traits\ClientTrait;

/**
 * Class RequestBuilder
 *
 * @method RequestBuilder accountInfo()
 * @method RequestBuilder documents()
 * @method RequestBuilder documentsImport()
 * @method RequestBuilder accurateAttributes()
 *
 * @package InvoiceApi
 */
class RequestBuilder
{
    use ClientTrait;

    /**
     * @var array
     */
    protected $parts = [];

    /**
     * @var array
     */
    protected $query = [];

    /**
     * @param string $name
     * @param array  $arguments
     *
     * @return RequestBuilder
     */
    public function __call($name, $arguments)
    {
        $arguments = reset($arguments);

        if (!$arguments) {
            $arguments = [Inflector::camel2id($name)];
        }

        return $this->addParts($arguments);
    }

    /**
     * @param array $parts
     *
     * @return $this
     */
    private function addParts(array $parts)
    {
        foreach ($parts as $part) {
            $this->addPart($part);
        }

        return $this;
    }

    /**
     * @param string $part
     *
     * @return $this
     */
    private function addPart($part)
    {
        $this->parts[] = $part;

        return $this;
    }

    /**
     * @param string $id
     *
     * @return $this
     */
    public function id($id)
    {
        $this->addPart($id);

        return $this;
    }

    /**
     * @param array $options
     *
     * @return Response
     * @throws \InvoiceApi\Exceptions\TransportException
     */
    public function get(array $options = [])
    {
        return $this->client->get($this->buildUri(), $this->buildOptions($options));
    }

    /**
     * @return string
     */
    private function buildUri()
    {
        return sprintf('/%s', implode('/', $this->parts));
    }

    /**
     * @param array $options
     *
     * @return array
     */
    private function buildOptions(array $options = [])
    {
        return ArrayHelper::merge(['query' => $this->query], $options);
    }

    /**
     * @param Model $model
     *
     * @return Model
     * @throws \InvoiceApi\Exceptions\TransportException
     */
    public function create(Model $model)
    {
        $modelClass = $model::className();

        return new $modelClass($this->post(['json' => $model->toArray()])->getData());
    }

    /**
     * @param array $options
     *
     * @return Response
     * @throws \InvoiceApi\Exceptions\TransportException
     */
    public function post(array $options = [])
    {
        return $this->client->post($this->buildUri(), $this->buildOptions($options));
    }

    /**
     * @param Model $model
     *
     * @return Model
     * @throws \InvoiceApi\Exceptions\TransportException
     */
    public function update(Model $model)
    {
        $modelClass = $model::className();

        return new $modelClass($this->put(['json' => $model->toArray()])->getData());
    }

    /**
     * @param array $options
     *
     * @return Response
     * @throws \InvoiceApi\Exceptions\TransportException
     */
    public function put(array $options = [])
    {
        return $this->client->put($this->buildUri(), $this->buildOptions($options));
    }

    /**
     * @param array $options
     *
     * @return Response
     * @throws \InvoiceApi\Exceptions\TransportException
     */
    public function delete(array $options = [])
    {
        return $this->client->delete($this->buildUri(), $this->buildOptions($options));
    }
}