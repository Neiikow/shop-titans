<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class QuestBossController extends AbstractController
{
    /**
     * @Route("/quest/boss", name="quest_boss")
     */
    public function index()
    {
        return $this->render('quest_boss/index.html.twig', [
            'controller_name' => 'QuestBossController',
        ]);
    }
}
