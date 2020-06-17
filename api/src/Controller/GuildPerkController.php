<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class GuildPerkController extends AbstractController
{
    /**
     * @Route("/guild/perk", name="guild_perk")
     */
    public function index()
    {
        return $this->render('guild_perk/index.html.twig', [
            'controller_name' => 'GuildPerkController',
        ]);
    }
}
