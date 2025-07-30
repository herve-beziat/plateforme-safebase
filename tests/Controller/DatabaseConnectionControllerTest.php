<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DatabaseConnectionControllerTest extends WebTestCase
{
    public function testTestConnectionSuccess(): void
    {
        $client = static::createClient();

        $payload = [
            'name' => 'Test API',
            'host' => 'host.docker.internal',
            'port' => 3306,
            'username' => 'root',
            'password' => '',
            'databaseName' => 'silver-micro'
        ];

        $client->request(
            'POST',
            '/api/test-connection',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($payload)
        );

        $this->assertResponseIsSuccessful(); // 200 OK
        $this->assertResponseHeaderSame('content-type', 'application/json');


        $response = json_decode($client->getResponse()->getContent(), true);
        $this->assertTrue($response['success']);
        $this->assertStringContainsString('Connexion sauvegardée avec succès', $response['message']);
    }
}
