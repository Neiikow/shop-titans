<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class RarityController extends AbstractController
{
    /**
     * @Route("/rarity", name="rarity")
     */
    public function index()
    {
        return $this->render('rarity/index.html.twig', [
            'controller_name' => 'RarityController',
        ]);
    }
}
