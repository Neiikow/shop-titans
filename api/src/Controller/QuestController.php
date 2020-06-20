<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class QuestController extends AbstractController
{
    /**
     * @Route("/quest", name="quest")
     */
    public function index()
    {
        return $this->render('quest/index.html.twig', [
            'controller_name' => 'QuestController',
        ]);
    }
}
