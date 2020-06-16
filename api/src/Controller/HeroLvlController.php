<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HeroLvlController extends AbstractController
{
    /**
     * @Route("/hero/lvl", name="hero_lvl")
     */
    public function index()
    {
        return $this->render('hero_lvl/index.html.twig', [
            'controller_name' => 'HeroLvlController',
        ]);
    }
}
