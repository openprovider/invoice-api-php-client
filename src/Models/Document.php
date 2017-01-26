<?php

namespace InvoiceApi\Models;

use InvoiceApi\Base\Object;
use InvoiceApi\Helpers\ArrayHelper;

/**
 * Class Document
 *
 * @package InvoiceApi\Models
 */
class Document extends Object
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var int
     */
    protected $accountId;

    /**
     * @var string
     */
    protected $status;

    /**
     * @var string
     */
    protected $createdAt;

    /**
     * @var string
     */
    protected $updatedAt;

    /**
     * @var DocumentAttribute[]
     */
    protected $attributes;

    /**
     * Document constructor.
     *
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $config['attributes'] = $this->convertArrayItemsToDocumentAttributes(ArrayHelper::getValue($config,
            'attributes', []));

        parent::__construct($config);
    }

    /**
     * @param array $attributes
     *
     * @return array
     */
    protected function convertArrayItemsToDocumentAttributes(array $attributes)
    {
        // convert arrays to DocumentAttribute objects
        foreach ($attributes as $index => $attribute) {
            if (!$attribute instanceof DocumentAttribute) {
                if (is_array($attribute)) {
                    $attributes[$index] = new DocumentAttribute($attribute);
                } else {
                    unset($attribute[$index]);
                }
            }
        }

        return $attributes;
    }

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
    public function getAccountId()
    {
        return $this->accountId;
    }

    /**
     * @param int $accountId
     *
     * @return $this
     */
    public function setAccountId($accountId)
    {
        $this->accountId = $accountId;

        return $this;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     *
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param string $createdAt
     *
     * @return $this
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return string
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param string $updatedAt
     *
     * @return $this
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return DocumentAttribute[]
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @param array|DocumentAttribute[] $attributes
     *
     * @return $this
     */
    public function setAttributes(array $attributes)
    {
        $this->attributes = $this->convertArrayItemsToDocumentAttributes($attributes);

        return $this;
    }
}