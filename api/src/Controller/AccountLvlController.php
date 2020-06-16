<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AccountLvlController extends AbstractController
{
    /**
     * @Route("/account/lvl", name="account_lvl")
     */
    public function index()
    {
        return $this->render('account_lvl/index.html.twig', [
            'controller_name' => 'AccountLvlController',
        ]);
    }
}
