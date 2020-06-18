<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ItemTypeController extends AbstractController
{
    /**
     * @Route("/item/type", name="item_type")
     */
    public function index()
    {
        return $this->render('item_type/index.html.twig', [
            'controller_name' => 'ItemTypeController',
        ]);
    }
}
