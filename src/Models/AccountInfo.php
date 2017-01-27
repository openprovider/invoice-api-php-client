<?php

namespace InvoiceApi\Models;

use InvoiceApi\Base\Model;

/**
 * Class AccountInfo
 *
 * @package InvoiceApi\Models
 */
class AccountInfo extends Model
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var int
     */
    protected $recognitionLimit;

    /**
     * @var int
     */
    protected $recognitionsLeft;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return int
     */
    public function getRecognitionLimit()
    {
        return $this->recognitionLimit;
    }

    /**
     * @param int $recognitionLimit
     *
     * @return $this
     */
    public function setRecognitionLimit($recognitionLimit)
    {
        $this->recognitionLimit = $recognitionLimit;

        return $this;
    }

    /**
     * @return int
     */
    public function getRecognitionsLeft()
    {
        return $this->recognitionsLeft;
    }

    /**
     * @param int $recognitionsLeft
     *
     * @return $this
     */
    public function setRecognitionsLeft($recognitionsLeft)
    {
        $this->recognitionsLeft = $recognitionsLeft;

        return $this;
    }
}