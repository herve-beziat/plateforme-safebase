<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomeControllerTest extends WebTestCase
{
    public function testHomePageIsSuccessful(): void
    {
        $client = static::createClient();
        $client->request('GET', '/'); // remplace par ta route réelle si besoin

        $this->assertResponseIsSuccessful(); // équivalent à code 200
    }
}
