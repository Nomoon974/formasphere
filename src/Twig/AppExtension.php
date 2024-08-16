<?php

namespace App\Twig;

use App\Service\RouteService;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;

class AppExtension extends AbstractExtension implements GlobalsInterface
{
    private RouteService $routeService;
    private UrlGeneratorInterface $urlGenerator;

    public function __construct(RouteService $routeService, UrlGeneratorInterface $urlGenerator)
    {
        $this->routeService = $routeService;
        $this->urlGenerator = $urlGenerator;
    }
    public function getGlobals(): array
    {
        $routeCollection = $this->routeService->getRoutes();

        if (!is_array($routeCollection)) {
            throw new \UnexpectedValueException('Expected routeCollection to be an array.');
        }

        $filteredRoutes = [];

        $routesToShow = [
            'app_overview',
        ];

        $routeTitles = [
            'app_overview' => 'Overview',
        ];

        foreach ($routesToShow as $routeName ) {
            if (isset($routeCollection[$routeName])) {
                $filteredRoutes[$routeName] = [
                    'url' => $this->urlGenerator->generate($routeName),
                    'title' => $routeTitles[$routeName] ?? $routeName ,// Utiliser le titre personnalisé ou le nom de la route si non défini
                ];
            }
        }

        return [
            'rou' => $filteredRoutes
        ];
    }
}

