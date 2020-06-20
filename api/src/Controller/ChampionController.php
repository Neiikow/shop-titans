<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ChampionController extends AbstractController
{
    /**
     * @Route("/champion", name="champion")
     */
    public function index()
    {
        return $this->render('champion/index.html.twig', [
            'controller_name' => 'ChampionController',
        ]);
    }
}
