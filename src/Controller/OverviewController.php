<?php

// src/Controller/OverviewController.php

namespace App\Controller;

use App\Entity\Spaces;
use App\Service\RouteService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\SecurityBundle\Security;

class OverviewController extends AbstractController
{


    #[Route('/overview', name: 'app_overview')]
    public function index(Security $security, ManagerRegistry $doctrine): Response
    {
        $user = $security->getUser();
        $spaces = $doctrine->getRepository(Spaces::class)->findAll();



        return $this->render('overview/index.html.twig', [
            'controller_name' => 'OverviewController',
            'user' => $user,
            'spaces' => $spaces,
        ]);
    }
}

