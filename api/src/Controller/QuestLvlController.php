<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class QuestLvlController extends AbstractController
{
    /**
     * @Route("/quest/lvl", name="quest_lvl")
     */
    public function index()
    {
        return $this->render('quest_lvl/index.html.twig', [
            'controller_name' => 'QuestLvlController',
        ]);
    }
}
