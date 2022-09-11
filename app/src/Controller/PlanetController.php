<?php

namespace App\Controller;

use App\Entity\Planet;
use App\Service\PlanetService;
use App\Repository\PlanetRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class PlanetController extends AbstractController
{


    public function __construct(
        protected PlanetService    $planetService,
        protected PlanetRepository $planetRepository
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
    #[Route('/planets/{id}', name: 'get_planets', methods: ['GET'])]
    public function getPlanet($id): JsonResponse
    {
        $planet = $this->planetService->getPlanet($id);

        return new JsonResponse($planet);
    }

    /**
     * @throws Exception
     */
    #[Route('/planet', name: 'post_planet', methods: ['POST'])]
    public function postPlanet(Request $request): JsonResponse
    {
        $params = (array)json_decode($request->getContent());
        $response = $this->planetRepository->add($params);

        if ($response instanceof Planet) {
            return new JsonResponse($response->toArray());
        }

        return new JsonResponse(['Error' => $response]);
    }
}