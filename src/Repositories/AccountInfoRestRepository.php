<?php

namespace InvoiceApi\Repositories;

use InvoiceApi\Exceptions\NotImplementedException;
use InvoiceApi\Models\AccountInfo;

/**
 * Class AccountInfoRepository
 *
 * @package InvoiceApi\Repositories
 */
class AccountInfoRestRepository extends RestRepository
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
        return AccountInfo::class;
    }

    /**
     * @return string
     */
    public function getUri()
    {
        return '/account-info';
    }
}