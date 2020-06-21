<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class EnchantmentController extends AbstractController
{
    /**
     * @Route("/enchantment", name="enchantment")
     */
    public function index()
    {
        return $this->render('enchantment/index.html.twig', [
            'controller_name' => 'EnchantmentController',
        ]);
    }
}
