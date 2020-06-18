<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class GuildUpgradeController extends AbstractController
{
    /**
     * @Route("/guild/upgrade", name="guild_upgrade")
     */
    public function index()
    {
        return $this->render('guild_upgrade/index.html.twig', [
            'controller_name' => 'GuildUpgradeController',
        ]);
    }
}
