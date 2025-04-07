<?php

namespace App\Twig;

use App\Service\RouteService;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;

class AppExtension extends AbstractExtension implements GlobalsInterface
{
    private RouteService $routeService;
    private UrlGeneratorInterface $urlGenerator;
    private Security $security;

    public function __construct(RouteService $routeService, UrlGeneratorInterface $urlGenerator, Security $security)
    {
        $this->routeService = $routeService;
        $this->urlGenerator = $urlGenerator;
        $this->security = $security;
    }
    public function getGlobals(): array
    {
        $routeCollection = $this->routeService->getRoutes();

        if (!is_array($routeCollection)) {
            throw new \UnexpectedValueException('Expected routeCollection to be an array.');
        }

        $filteredRoutes = [];

        $routeIcons = [
            'app_overview' => 'mingcute:grid-line',
            'admin' => 'eos-icons:admin-outlined',
        ];

        $routesToShow = [
            'app_overview',
            'admin',
        ];

        $routeTitles = [
            'app_overview' => 'Espaces',
            'admin' => 'Tableau de bord Admin',
        ];

        foreach ($routesToShow as $routeName ) {
            if ( $routeName === 'admin' && !$this->security->isGranted('ROLE_ADMIN')) {
                continue;
            }
            if (isset($routeCollection[$routeName])) {
                $filteredRoutes[$routeName] = [
                    'url' => $this->urlGenerator->generate($routeName),
                    'title' => $routeTitles[$routeName] ?? $routeName ,// Utiliser le titre personnalisé ou le nom de la route si non défini
                    'icon' =>$routeIcons[$routeName] ?? '',
                ];
            }
        }

        return [
            'routes' => $filteredRoutes
        ];
    }
}

