<?php

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

$routes = new RouteCollection();
$routes->add('get_app_config', new Route(
    '/api/app',
    ['_controller' => [\App\Controller\IndexController::class, 'getAppConfig']],
    [], [], null, [], ['GET'],

));

return $routes;