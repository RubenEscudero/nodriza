<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\PlanetService;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class PlanetController extends AbstractController
{
    public function __construct(
        protected PlanetService $planetService
    )
    {
    }

    /**
     * @param $id
     * @return JsonResponse
     * @throws TransportExceptionInterface
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     */
    #[Route(
        '/planets/{id}',
        name: 'get_planets',
        methods: ['GET']
    )]
    public function getPlanets($id): JsonResponse
    {
        $planet = $this->planetService->getPlanet($id);

        return new JsonResponse($planet);
    }
}