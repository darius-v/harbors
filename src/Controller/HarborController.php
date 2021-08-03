<?php

namespace App\Controller;

use App\Service\Harbors;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class HarborController extends AbstractController
{
    /**
     * @Route("/harbor", name="harbors_list")
     */
    public function harborsList(Harbors $harbors): JsonResponse
    {
        $list = $harbors->harborsList();

        return $this->json($list);
    }

    /**
     * @Route("/harbor/{harborId}", name="harbors_list")
     */
    public function harborWeather(string $harborId, Harbors $harbors): JsonResponse
    {
        try {
            $harbor = $harbors->getHarborWeather($harborId);
        } catch (NotFoundHttpException $e) {
            return $this->json(['error' => 'Harbor was not found by id']);
        }

        return $this->json($harbor);
    }
}