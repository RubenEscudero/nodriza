<?php

namespace App\Service;

use stdClass;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class PlanetService
{
    private int $currentPlanetId;

    public function __construct(
        private readonly HttpClientInterface $httpClient,
        private                              $url
    )
    {
    }

    /**
     * @param $id
     * @return stdClass
     * @throws TransportExceptionInterface
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     */
    public function getPlanet($id): stdClass
    {
        $this->currentPlanetId = $id;
        $response = $this->httpClient->request('GET', $this->url . $id);

        if ($response->getStatusCode() != Response::HTTP_OK) {
            if ($response->getStatusCode() == Response::HTTP_NOT_FOUND) {
                throw new HttpException($response->getStatusCode(), 'Planet not found, try other id.');
            }
            throw new HttpException($response->getStatusCode(), 'Please try again, an error occurred.');
        }

        return $this->planetDataFormatter(json_decode($response->getContent()));
    }

    private function planetDataFormatter($planetData): stdClass
    {
        $planet = new stdClass();
        $planet->id = $this->currentPlanetId;
        $planet->name = $planetData->name;
        $planet->rotation_period = $planetData->rotation_period;
        $planet->orbital_period = $planetData->orbital_period;
        $planet->diameter = $planetData->diameter;
        $planet->films_count = count($planetData->films);
        $planet->created = $planetData->created;
        $planet->edited = $planetData->edited;
        $planet->url = $planetData->url;

        return $planet;
    }
}