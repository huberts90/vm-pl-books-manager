<?php

namespace Tests\Infrastructure\Api\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BookControllerTest extends WebTestCase
{
    public function testPOST()
    {
        $client = static::createClient();

        $client->request(
            'POST', '/api/books/', [], [],
            ['Content-Type' => 'application/json'],
            '{"name":"Juliusz", "category": "non-fiction"}'
        );

        $this->assertEquals(201, $client->getResponse()->getStatusCode());
    }

    public function testPOSTBadRequest()
    {
        $client = static::createClient();

        $client->request(
            'POST', '/api/books/', [], [],
            ['Content-Type' => 'application/json'],
            '{"name":"Juliusz", "category": "undefined"}'
        );

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
    }

    public function testPUT()
    {
        $client = static::createClient();

        $client->request(
            'POST', '/api/books/', [], [],
            ['Content-Type' => 'application/json'],
            '{"name":"Juliusz", "category": "non-fiction"}'
        );

        $id = json_decode($client->getResponse()->getContent(), true)['id'];
        $client->request(
            'PUT', '/api/books/' . $id . '/', [], [],
            ['Content-Type' => 'application/json'],
            '{"name":"Tyberiusz", "category": "non-fiction"}'
        );
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertRegExp('/Tyberiusz/', $client->getResponse()->getContent());
    }

    public function testDelete()
    {
        $client = static::createClient();

        $client->request(
            'POST', '/api/books/', [], [],
            array(
                'Content-Type' => 'application/json',
            ),
            '{"name":"Juliusz", "category": "non-fiction"}'
        );

        $id = json_decode($client->getResponse()->getContent(), true)['id'];
        $client->request(
            'DELETE', '/api/books/' . $id . '/', [], [],
            ['Content-Type' => 'application/json'],
        );
        $this->assertEquals(204, $client->getResponse()->getStatusCode());
    }

    public function testGetNotFound()
    {
        $client = static::createClient();
        $client->request(
            'DELETE', '/api/books/0/', [], [],
            ['Content-Type' => 'application/json'],
        );
        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }

    public function testGetAll()
    {
        $client = static::createClient();

        $client->request(
            'POST', '/api/books/', [], [],
            array(
                'Content-Type' => 'application/json',
            ),
            '{"name":"Juliusz", "category": "non-fiction"}'
        );

        $client->request(
            'GET', '/api/books/', [], [],
            ['Content-Type' => 'application/json'],
        );
        $books = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertGreaterThan(20, $books);
    }
}
