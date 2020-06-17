<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SlotController extends AbstractController
{
    /**
     * @Route("/slot", name="slot")
     */
    public function index()
    {
        return $this->render('slot/index.html.twig', [
            'controller_name' => 'SlotController',
        ]);
    }
}
