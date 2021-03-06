<?php

namespace Core;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;

class HttpKernel
{

    public function handleRequest(Request $request): Response
    {
        $context = new RequestContext();
        $context->fromRequest($request);

        // Routing can match routes with incoming requests
        $routes = include PROJECT_ROOT.'/config/router.php';
        $matcher = new UrlMatcher($routes, $context);

        try {
            $parameters = $matcher->match($request->getPathInfo());
        } catch (MethodNotAllowedException | ResourceNotFoundException $e) {
            $data = [
                'code' => 404,
                'message' => JsonResponse::$statusTexts[404],
            ];
            return $response = new \Symfony\Component\HttpFoundation\JsonResponse($data, 404);
        }

        if (!array($parameters['_controller'])) {
            throw new \Exception('`_controller` must be type of array');
        }

        $controller_class_name = $parameters['_controller'][0];
        $controller_method_name = $parameters['_controller'][1].'Action';

        $controller = new $controller_class_name();
        if (!is_a($controller, AbstractController::class)) {
            throw new \Exception("`{$controller_class_name}` must be type of ". AbstractController::class);
        }
        $before_action_result = $controller->beforeAction();
        if (is_a($before_action_result, Response::class)) {
            return $before_action_result;
        }
        /** @var \Symfony\Component\HttpFoundation\Response $response */
        return $response = $controller->$controller_method_name($request);
    }
}