<?php

namespace App\Controller;

use App\Repository\SpacesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class OverviewController extends AbstractController
{
    #[Route('/overview', name: 'app_overview')]
    public function index(SpacesRepository $spacesRepository): Response
    {
        $user = $this->getUser();

        return $this->render('overview/index.html.twig', [
            'controller_name' => 'OverviewController',
        ]);
    }
}
