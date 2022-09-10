<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PlanetControllerTest extends WebTestCase
{
    public function testGetPlanet()
    {
        $client = self::createClient();
        $client->request('GET', '/planets/1');
        $response = (array)json_decode($client->getResponse()->getContent());
        self::assertIsArray($response);
    }
}
