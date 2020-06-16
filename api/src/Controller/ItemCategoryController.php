<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ItemCategoryController extends AbstractController
{
    /**
     * @Route("/item/category", name="item_category")
     */
    public function index()
    {
        return $this->render('item_category/index.html.twig', [
            'controller_name' => 'ItemCategoryController',
        ]);
    }
}
