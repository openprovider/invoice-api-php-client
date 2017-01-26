<?php


namespace InvoiceApi\Repositories;

/**
 * Interface Repository
 *
 * @package InvoiceApi\Repositories
 */
interface Repository
{
    /**
     * @return array
     */
    public function getList();

    /**
     * @return mixed
     */
    public function get();

    /**
     * @param mixed $id
     *
     * @return mixed
     */
    public function getById($id);
}