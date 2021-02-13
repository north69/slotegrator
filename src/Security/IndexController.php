<?php

namespace Security;

use Core\ApiControllerTrait;
use Core\Auth\Auth;
use Core\ErrorContainer\ApiErrorContainerTrait;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class IndexController
{
    use ApiControllerTrait;
    use ApiErrorContainerTrait;

    public function loginAction(Request $request): JsonResponse
    {
        $login = $request->query->get('login');
        $password = $request->query->get('password');
        if (!$login || !$password) {
            return $this->jsonErrorResponse(JsonResponse::HTTP_BAD_REQUEST);
        }
        if (!Auth::i()->login($login, $password)) {
            $this->mergeErrors(Auth::i()->getErrorContainer());
            return $this->jsonErrorResponse(JsonResponse::HTTP_BAD_REQUEST, $this->getErrors());
        }
        return $this->jsonResponse();
    }

    public function logoutAction(): JsonResponse
    {
        Auth::i()->logout();
        return $this->jsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }
}