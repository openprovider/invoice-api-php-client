<?php
use InvoiceApi\Client;
use InvoiceApi\Exceptions\BuilderException;
use InvoiceApi\Transports\DefaultTransport;

/**
 * Class ClientTest
 */
class ClientTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testBuildClient()
    {
        $client = Client::build()
            ->setTransport(new DefaultTransport())
            ->setBaseUri('https://invoice-api.com/api/v1')
            ->setBearerToken('test-token')
            ->getClient();

        $this->assertNotEmpty($client);
        $this->assertInstanceOf(Client::class, $client);
    }

    public function testBuildClientAndUseUndefinedMethod()
    {
        $this->expectException(BuilderException::class);

        Client::build()->someUndefinedMethod();
    }

    protected function _before()
    {
    }

    protected function _after()
    {
    }
}