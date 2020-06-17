<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ConsumableController extends AbstractController
{
    /**
     * @Route("/consumable", name="consumable")
     */
    public function index()
    {
        return $this->render('consumable/index.html.twig', [
            'controller_name' => 'ConsumableController',
        ]);
    }
}
