<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class FriendshipLvlController extends AbstractController
{
    /**
     * @Route("/friendship/lvl", name="friendship_lvl")
     */
    public function index()
    {
        return $this->render('friendship_lvl/index.html.twig', [
            'controller_name' => 'FriendshipLvlController',
        ]);
    }
}
