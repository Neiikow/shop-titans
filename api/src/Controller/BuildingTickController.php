<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BuildingTickController extends AbstractController
{
    /**
     * @Route("/building/tick", name="building_tick")
     */
    public function index()
    {
        return $this->render('building_tick/index.html.twig', [
            'controller_name' => 'BuildingTickController',
        ]);
    }
}
