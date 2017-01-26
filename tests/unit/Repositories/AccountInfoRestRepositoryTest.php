<?php

namespace Repositories;

use InvoiceApi\Client;
use InvoiceApi\Models\AccountInfo;

/**
 * Class AccountInfoTest
 *
 * @package Endpoints
 */
class AccountInfoRestRepositoryTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @ignore
     */
    public function testGetAccountInfo()
    {
        $transport = $this->tester->stubTransportWithResponse($this->tester->stubResponse([
            'data' => [
                'id' => 1,
                'recognitionLimit' => 40,
                'recognitionsLeft' => 40,
            ],
        ]));

        $client = Client::build()->setTransport($transport)->getClient();

        $accountInfo = $client->accountInfo()->get();

        $this->assertNotEmpty($accountInfo);
        $this->assertInstanceOf(AccountInfo::class, $accountInfo);
    }

    protected function _before()
    {
    }

    protected function _after()
    {
    }
}