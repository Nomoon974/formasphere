<?php

namespace App\Controller;

use App\Entity\Spaces;
use App\Repository\SpacesRepository;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class OverviewController extends AbstractController
{
    #[Route('/overview', name: 'app_overview')]
    public function index(SpacesRepository $spacesRepository, Security $security, UserRepository $userRepository,ManagerRegistry $doctrine): Response
    {
        $user = $security->getUser();
        $spaces = $doctrine->getRepository(Spaces::class)->findAll();

        return $this->render('overview/index.html.twig', [
            'controller_name' => 'OverviewController',
            'user' => $user,
            'spaces' => $spaces
        ]);
    }
}
