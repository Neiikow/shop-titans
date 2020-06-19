<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BuildingController extends AbstractController
{
    /**
     * @Route("/building", name="building")
     */
    public function index()
    {
        return $this->render('building/index.html.twig', [
            'controller_name' => 'BuildingController',
        ]);
    }
}
