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
            'rotation_period' => 'Rotation test',
            'orbital_period' => 'Orbital test',
            'diameter' => 6,
        ];

        $client->request('POST', '/planet', ['json' => $params]);
    }
}
