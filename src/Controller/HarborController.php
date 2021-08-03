<?php

namespace App\Controller;

use App\Service\Harbors;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HarborController extends AbstractController
{
    /**
     * @Route("/harbor", name="harbors_list")
     */
    public function harborsList(Harbors $harbors): Response
    {
        $list = $harbors->harborsList();

        return $this->json($list);
    }
}