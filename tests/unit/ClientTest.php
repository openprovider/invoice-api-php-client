<?php
use InvoiceApi\Client;
use InvoiceApi\Exceptions\BuilderException;
use InvoiceApi\Helpers\ArrayHelper;

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

    public function testStubbedClientRequest()
    {
        $transport = $this->tester->stubTransportWithResponse($this->tester->stubResponse([
            'data' => [
                'test' => true,
            ],
        ]));

        $client = Client::build()->setTransport($transport)->getClient();

        $data = $client->rawRequest('GET', '/uri');

        $this->assertNotEmpty($data);

        $data = ArrayHelper::getValue($data, 'data', []);

        $this->assertArrayHasKey('test', $data);
        $this->assertTrue($data['test']);
    }

    /**
     * @group Remote
     */
    public function testClientRequest()
    {
        $client = Client::build()
            ->setBaseUri('https://httpbin.org')
            ->getClient();

        $data = $client->rawRequest('GET', '/get');

        $this->assertNotEmpty($data);
        $this->assertArrayHasKey('headers', $data);
        $this->assertArrayHasKey('url', $data);
        $this->assertEquals($data['url'], 'https://httpbin.org/get');
    }

    /**
     * @group Remote
     */
    public function testClientRequestBearerToken()
    {
        $client = Client::build()
            ->setBearerToken('test-token')
            ->setBaseUri('https://httpbin.org')
            ->getClient();

        $client->rawRequest('GET', '/get');

        $request = $client->getLastRequest();

        $this->assertNotEmpty($request);
        $this->assertNotEmpty($request->getHeaders());

        $header = $request->getHeader('Authorization');
        $header = reset($header);

        $this->assertNotEmpty($header);
        $this->assertEquals('Bearer test-token', $header);
    }

    protected function _before()
    {
    }

    protected function _after()
    {
    }
}