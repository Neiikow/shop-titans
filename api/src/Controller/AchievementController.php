<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AchievementController extends AbstractController
{
    /**
     * @Route("/achievement", name="achievement")
     */
    public function index()
    {
        return $this->render('achievement/index.html.twig', [
            'controller_name' => 'AchievementController',
        ]);
    }
}
