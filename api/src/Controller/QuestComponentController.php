<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class QuestComponentController extends AbstractController
{
    /**
     * @Route("/quest/component", name="quest_component")
     */
    public function index()
    {
        return $this->render('quest_component/index.html.twig', [
            'controller_name' => 'QuestComponentController',
        ]);
    }
}
