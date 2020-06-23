<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BuildingLvlController extends AbstractController
{
    /**
     * @Route("/building/lvl", name="building_lvl")
     */
    public function index()
    {
        return $this->render('building_lvl/index.html.twig', [
            'controller_name' => 'BuildingLvlController',
        ]);
    }
}
