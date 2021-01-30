<?php

use Common\Index;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

require dirname(__DIR__).'/config/bootstrap.php';

$route = new Route('/blog/{slug}', ['_controller' => Index::class]);
$routes = new RouteCollection();
$routes->add('blog_show', $route);

$context = new RequestContext();
$request = Request::createFromGlobals();
$context->fromRequest($request);

// Routing can match routes with incoming requests
$matcher = new UrlMatcher($routes, $context);

try {
    $parameters = $matcher->match($request->getPathInfo());
} catch (ResourceNotFoundException $e) {
    $data = [
        'code' => 404,
        'message' => JsonResponse::$statusTexts[404],
    ];
    $response = new \Symfony\Component\HttpFoundation\JsonResponse($data, 404);
    $response->send();
    die;
}


$index = new Index();
$index->hello();