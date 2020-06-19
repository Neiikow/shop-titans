<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SlotSizeController extends AbstractController
{
    /**
     * @Route("/slot/size", name="slot_size")
     */
    public function index()
    {
        return $this->render('slot_size/index.html.twig', [
            'controller_name' => 'SlotSizeController',
        ]);
    }
}
