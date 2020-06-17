<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class QuestAreaController extends AbstractController
{
    /**
     * @Route("/quest/area", name="quest_area")
     */
    public function index()
    {
        return $this->render('quest_area/index.html.twig', [
            'controller_name' => 'QuestAreaController',
        ]);
    }
}
