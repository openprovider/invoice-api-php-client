<?php

use InvoiceApi\Client;
use InvoiceApi\Models\AccurateAttribute;

/**
 * Class DocumentsTest
 */
class DocumentsAccurateAttributesTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testCreateAccurateAttributes()
    {
        $testAttributes = [
            [
                'name' => 'test-name',
                'value' => 'test-value',
            ],
        ];

        $transport = $this->tester->stubTransportWithResponse($this->tester->stubResponse([
            'data' => $testAttributes,
        ]));

        $client = Client::build()->setTransport($transport)->getClient();

        $response = $client->documents()->id(1)->accurateAttributes()->post([
            'json' => $testAttributes,
        ]);

        $this->assertNotEmpty($response);
        $this->assertNotEmpty($response->getData());

        $attributes = $response->toModelList(AccurateAttribute::class);

        $this->assertNotEmpty($attributes);

        /** @var AccurateAttribute $attribute */
        $attribute = reset($attributes);

        $this->assertEquals('test-name', $attribute->getName());
        $this->assertEquals('test-value', $attribute->getValue());
    }

    protected function _before()
    {
    }

    protected function _after()
    {
    }
}