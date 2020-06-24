<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class QuestKeyController extends AbstractController
{
    /**
     * @Route("/quest/key", name="quest_key")
     */
    public function index()
    {
        return $this->render('quest_key/index.html.twig', [
            'controller_name' => 'QuestKeyController',
        ]);
    }
}
