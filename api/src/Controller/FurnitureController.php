<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class FurnitureController extends AbstractController
{
    /**
     * @Route("/furniture", name="furniture")
     */
    public function index()
    {
        return $this->render('furniture/index.html.twig', [
            'controller_name' => 'FurnitureController',
        ]);
    }
}
