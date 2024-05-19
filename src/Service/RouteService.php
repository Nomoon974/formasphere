<?php

namespace App\Service;

use Symfony\Component\Routing\RouterInterface;

class RouteService
{
    public function __construct(private readonly RouterInterface $router)
    {

    }

    public function getRoutes(): array
    {
        // Récupère la collection de toutes les routes
        $routeCollection = $this->router->getRouteCollection();
        $routes = [];

        // Itère sur chaque route dans la collection
        foreach ($routeCollection as $name => $route) {
            // Ajoute le nom de la route et son chemin au tableau des routes
            $routes[$name] = $route->getPath();
        }

        return $routes;
    }
}
