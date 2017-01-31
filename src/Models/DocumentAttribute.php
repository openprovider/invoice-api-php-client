<?php

namespace InvoiceApi\Models;

use InvoiceApi\Base\Model;

/**
 * Class DocumentAttribute
 *
 * @package InvoiceApi\Models
 */
class DocumentAttribute extends Model
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $value;

    /**
     * @var float
     */
    protected $probability;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return float
     */
    public function getProbability()
    {
        return $this->probability;
    }

    /**
     * @param float $probability
     *
     * @return $this
     */
    public function setProbability($probability)
    {
        $this->probability = $probability;

        return $this;
    }
}