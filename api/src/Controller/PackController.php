<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PackController extends AbstractController
{
    /**
     * @Route("/pack", name="pack")
     */
    public function index()
    {
        return $this->render('pack/index.html.twig', [
            'controller_name' => 'PackController',
        ]);
    }
}
