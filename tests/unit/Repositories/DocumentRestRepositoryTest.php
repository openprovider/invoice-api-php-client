<?php

namespace Repositories;

use InvoiceApi\Client;
use InvoiceApi\Models\Document;
use InvoiceApi\Models\DocumentAttribute;

/**
 * Class DocumentRestRepositoryTest
 *
 * @package Repositories
 */
class DocumentRestRepositoryTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testGetDocument()
    {
        $transport = $this->tester->stubTransportWithResponse($this->tester->stubResponse([
            'data' => [
                'id' => 1,
                'accountId' => 1,
                'status' => 'created',
                'createdAt' => date(DATE_ISO8601),
                'updatedAt' => date(DATE_ISO8601),
                'attributes' => [
                    [
                        'name' => 'contact_id',
                        'value' => '1',
                        'probability' => 1,
                    ],
                    [
                        'name' => 'date',
                        'value' => '2017-01-26',
                        'probability' => 1,
                    ],
                    [
                        'name' => 'currency',
                        'value' => 'EUR',
                        'probability' => 1,
                    ],
                    [
                        'name' => 'amount',
                        'value' => '10.0',
                        'probability' => 0.558,
                    ],
                    [
                        'name' => 'number',
                        'value' => '1',
                        'probability' => 1,
                    ],
                    [
                        'name' => 'type_id',
                        'value' => '1',
                        'probability' => 1,
                    ],
                ],
            ],
        ]));

        $client = Client::build()->setTransport($transport)->getClient();

        $document = $this->getDocument($client, 1);

        $this->assertNotEmpty($document);
        $this->assertInstanceOf(Document::class, $document);

        $this->assertNotEmpty($document->getAttributes());
        $this->assertInstanceOf(DocumentAttribute::class, $document->getAttributes()[0]);
    }

    /**
     * @param Client $client
     * @param mixed  $id
     *
     * @return Document
     */
    protected function getDocument(Client $client, $id)
    {
        return $client->documents()->getById($id);
    }

    public function testImportDocument()
    {
        $transport = $this->tester->stubTransportWithResponse($this->tester->stubResponse(['data' => [1]]));

        $client = Client::build()->setTransport($transport)->getClient();

        $ids = $client->documents()->import('tests/_data/test.pdf');

        $this->assertNotEmpty($ids);
    }

    protected function _before()
    {
    }

    protected function _after()
    {
    }
}