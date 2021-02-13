<?php

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

$routes_map = [
    'get_app_config' => [
        'path' => '/api/app',
        'meta' => ['_controller' => [\App\Controller\IndexController::class, 'getAppConfig']],
        'methods' => ['GET'],
    ],
    'login' => [
        'path' => '/api/security/login',
        'meta' => ['_controller' => [\Security\IndexController::class, 'login']],
        'methods' => ['GET'],
    ],
    'logout' => [
        'path' => '/api/security/logout',
        'meta' => ['_controller' => [\Security\IndexController::class, 'logout']],
        'methods' => ['GET'],
    ]
];

$routes = new RouteCollection();
foreach ($routes_map as $name => $route) {
    $routes->add($name, new Route(
        $route['path'],
        $route['meta'],
        [], [], null, [], $route['methods'],
    ));
}

return $routes;