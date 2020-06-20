<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ComponentController extends AbstractController
{
    /**
     * @Route("/component", name="component")
     */
    public function index()
    {
        return $this->render('component/index.html.twig', [
            'controller_name' => 'ComponentController',
        ]);
    }
}
