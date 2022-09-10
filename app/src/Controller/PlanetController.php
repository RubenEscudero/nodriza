<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Service\PlanetService;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class PlanetController extends AbstractController
{
    public function __construct(
        protected PlanetService $planetService
    )
    {
    }

    /**
     * @throws TransportExceptionInterface
     */
    #[Route(
        '/planets/{id}',
        name: 'get_planets',
        requirements: [
            'id' => '\b[0-9]+\b'
        ],
        methods: ['GET']
    )]
    public function getPlanets($id): JsonResponse
    {
        $planet = $this->planetService->getPlanet($id);

        return new JsonResponse($planet);
    }
}