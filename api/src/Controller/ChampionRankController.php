<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ChampionRankController extends AbstractController
{
    /**
     * @Route("/champion/rank", name="champion_rank")
     */
    public function index()
    {
        return $this->render('champion_rank/index.html.twig', [
            'controller_name' => 'ChampionRankController',
        ]);
    }
}
