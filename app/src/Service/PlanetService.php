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
            $error = new stdClass();
            $error->HTTP = $response->getStatusCode();
            $error->message = 'Please try again, an error occurred.';

            if ($response->getStatusCode() == Response::HTTP_NOT_FOUND) {
                $error->message = 'Planet not found, try other id.';
            }

            return $error;
        }

        return $this->planetDataFormatter(json_decode($response->getContent()));
    }

    private function planetDataFormatter($planetData): stdClass
    {
        $planet = new stdClass();
        $planet->id = $this->currentPlanetId;
        $planet->name = $planetData->name;
        $planet->rotation_period = (int)$planetData->rotation_period;
        $planet->orbital_period = (int)$planetData->orbital_period;
        $planet->diameter = (int)$planetData->diameter;
        $planet->films_count = count($planetData->films);
        $planet->created = $planetData->created;
        $planet->edited = $planetData->edited;
        $planet->url = $planetData->url;

        return $planet;
    }
}