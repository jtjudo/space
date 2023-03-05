<?php

namespace App\tests\Application;

use App\Repository\ClientRepository;
use App\Repository\RecordRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RecordTest extends WebTestCase
{
    private KernelBrowser $client;
    private RecordRepository|null $recordRepository;
    private ClientRepository|null $clientRepository;

    public function setUp(): void
    {
        $this->client = static::createClient();
        $this->recordRepository = $this->getContainer()->get(RecordRepository::class);
        $this->clientRepository = $this->getContainer()->get(ClientRepository::class);
        BaseTest::setBearer($this->client);
    }

    public function testNewRecord()
    {
        $id = $this->getClientId();

        $this->client->request(
            'POST',
            '/api/record/new',
            [],
            [],
            ['CONTENT_TYPE' => BaseTest::CONTENT_TYPE],
            json_encode([
                'clientId' => $id,
                'startDate' => BaseTest::getRandomDate(),
                'price' => BaseTest::getRandomNumber(),
            ])
        );

        $this->assertResponseIsSuccessful();
    }

    public function testGetRecords()
    {

        $this->client->request(
            'GET',
            "/api/records",
            [],
            [],
            ['CONTENT_TYPE' => BaseTest::CONTENT_TYPE],
        );

        $this->assertResponseIsSuccessful();
    }

    public function testGetRecordById()
    {

        $id = $this->getRecordId();

        $this->client->request(
            'GET',
            "/api/record/$id",
            [],
            [],
            ['CONTENT_TYPE' => BaseTest::CONTENT_TYPE],
        );

        $this->assertResponseIsSuccessful();
    }

    public function testGetRecordsByClient()
    {

        $id = $this->getClientId();

        $this->client->request(
            'GET',
            "/api/records/client/$id",
            [],
            [],
            ['CONTENT_TYPE' => BaseTest::CONTENT_TYPE],
        );

        $this->assertResponseIsSuccessful();
    }

    public function testGetRecordsBySpace()
    {

        $this->client->request(
            'GET',
            "/api/records/space/1",
            [],
            [],
            ['CONTENT_TYPE' => BaseTest::CONTENT_TYPE],
        );

        $this->assertResponseIsSuccessful();
    }

    public function testRemoveRecord()
    {
        $id = $this->getRecordId();

        $this->client->request(
            'DELETE',
            "/api/record/remove/$id",
            [],
            [],
            ['CONTENT_TYPE' => BaseTest::CONTENT_TYPE],
        );

        $this->assertResponseIsSuccessful();
    }

    public function testUpdateRecord()
    {
        $id = $this->getRecordId();

        $this->client->request(
            'PUT',
            "/api/record/update/$id",
            [],
            [],
            ['CONTENT_TYPE' => BaseTest::CONTENT_TYPE],
            json_encode([
                'startDate' => BaseTest::getRandomDate(),
                'price' => BaseTest::getRandomNumber(),
            ])
        );

        $this->assertResponseIsSuccessful();
    }

    private function getClientId(): int
    {
        $clients = $this->clientRepository->findAll();

        if ($clients) {
            return $clients[0]->getId();
        }

        return 1;
    }

    private function getRecordId(): int
    {
        $record = $this->recordRepository->findAll();

        if ($record) {
            return $record[0]->getId();
        }

        return 1;
    }
}