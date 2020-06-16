<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ShopExpansionController extends AbstractController
{
    /**
     * @Route("/shop/expansion", name="shop_expansion")
     */
    public function index()
    {
        return $this->render('shop_expansion/index.html.twig', [
            'controller_name' => 'ShopExpansionController',
        ]);
    }
}
