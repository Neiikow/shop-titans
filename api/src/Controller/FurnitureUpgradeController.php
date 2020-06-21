<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class FurnitureUpgradeController extends AbstractController
{
    /**
     * @Route("/furniture/upgrade", name="furniture_upgrade")
     */
    public function index()
    {
        return $this->render('furniture_upgrade/index.html.twig', [
            'controller_name' => 'FurnitureUpgradeController',
        ]);
    }
}
