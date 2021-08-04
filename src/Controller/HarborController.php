<?php

namespace App\Controller;

use App\Service\Harbors;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

class HarborController extends AbstractController
{
    /**
     * @Route("/harbor", name="harbors_list")
     */
    public function harborsList(Harbors $harbors): JsonResponse
    {
        try {
            $list = $harbors->harborsList();
        } catch (Throwable $e) {
            return $this->error('Unexpected error');
        }

        return $this->json($list);
    }

    /**
     * @Route("/harbor/{harborId}", name="harbor_weather")
     */
    public function harborWeather(string $harborId, Harbors $harbors): JsonResponse
    {
        try {
            $harbor = $harbors->getHarborWeather($harborId);
        } catch (NotFoundHttpException $e) {
            return $this->error('Harbor was not found by id');
        } catch (Throwable $e) {
            return $this->error('Unexpected error');
        }

        return $this->json($harbor);
    }

    /**
     * @Route("/map", name="harbor_map")
     */
    public function map(Harbors $harbors): Response
    {
        $harbors = $harbors->getForMap();

        return $this->render('map.html.twig', [
            'harbors' => json_encode($harbors),
        ]);
    }

    private function error(string $error): JsonResponse
    {
        return $this->json(['error' => $error]);
    }
}