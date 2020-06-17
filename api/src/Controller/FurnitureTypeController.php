<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class FurnitureTypeController extends AbstractController
{
    /**
     * @Route("/furniture/type", name="furniture_type")
     */
    public function index()
    {
        return $this->render('furniture_type/index.html.twig', [
            'controller_name' => 'FurnitureTypeController',
        ]);
    }
}
