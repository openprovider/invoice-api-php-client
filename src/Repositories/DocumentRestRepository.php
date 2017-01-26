<?php

namespace InvoiceApi\Repositories;

use InvoiceApi\Exceptions\NotImplementedException;
use InvoiceApi\Models\Document;

/**
 * Class DocumentRestRepository
 *
 * @package InvoiceApi\Repositories
 */
class DocumentRestRepository extends RestRepository
{
    public function getList()
    {
        throw new NotImplementedException();
    }

    /**
     * @return string
     */
    public function getModelClass()
    {
        return Document::class;
    }

    /**
     * @return string
     */
    public function getUri()
    {
        return '/documents';
    }

    /**
     * @param string|resource
     *
     * @return array
     *
     * @throws \InvoiceApi\Exceptions\TransportException
     */
    public function import($file)
    {
        if (!is_resource($file)) {
            $file = fopen($file, 'r');
        }

        return $this->client->request('POST', '/documents-import', ['body' => $file]);
    }
}