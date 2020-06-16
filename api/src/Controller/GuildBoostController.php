<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class GuildBoostController extends AbstractController
{
    /**
     * @Route("/guild/boost", name="guild_boost")
     */
    public function index()
    {
        return $this->render('guild_boost/index.html.twig', [
            'controller_name' => 'GuildBoostController',
        ]);
    }
}
