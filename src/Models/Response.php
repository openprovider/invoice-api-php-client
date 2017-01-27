<?php

namespace InvoiceApi\Models;

use InvoiceApi\Base\Model;
use InvoiceApi\Helpers\ArrayHelper;

/**
 * Class Response
 *
 * @package InvoiceApi\Models
 */
class Response extends Model
{
    /**
     * @var array
     */
    protected $data;

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param string $modelClass
     *
     * @return Model
     */
    public function toModel($modelClass)
    {
        return new $modelClass($this->data);
    }

    /**
     * @param string $modelClass
     *
     * @return Model
     */
    public function toModelList($modelClass)
    {
        return array_map(function ($item) use ($modelClass) {
            return new $modelClass($item);
        }, ArrayHelper::getValue($this->data, 'items', $this->data));
    }
}