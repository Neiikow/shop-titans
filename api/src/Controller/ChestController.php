<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ChestController extends AbstractController
{
    /**
     * @Route("/chest", name="chest")
     */
    public function index()
    {
        return $this->render('chest/index.html.twig', [
            'controller_name' => 'ChestController',
        ]);
    }
}
