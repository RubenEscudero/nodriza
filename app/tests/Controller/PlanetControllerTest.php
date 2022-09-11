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

    public function testPostPlanet()
    {
        $client = self::createClient();

        $params = [
            'id' => random_int(1000, 9999),
            'name' => 'Planet test',
            'rotation_period' => 5,
            'orbital_period' => 6,
            'diameter' => 6,
        ];

        $client->jsonRequest('POST', '/planet', $params);
    }
}
