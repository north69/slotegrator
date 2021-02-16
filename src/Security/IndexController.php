<?php

namespace Security;

use Core\AbstractController;
use Core\ApiControllerTrait;
use Core\Auth\Auth;
use Core\ErrorContainer\ApiErrorContainerTrait;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class IndexController extends AbstractController
{
    use ApiControllerTrait;
    use ApiErrorContainerTrait;

    public function loginAction(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $login = $data['username'] ?? null;
        $password = $data['password'] ?? null;
        if (!$login || !$password) {
            return $this->jsonErrorResponse(JsonResponse::HTTP_BAD_REQUEST);
        }
        if (!Auth::i()->login($login, $password)) {
            $this->mergeErrors(Auth::i()->getErrorContainer());
            return $this->jsonErrorResponse(JsonResponse::HTTP_BAD_REQUEST, $this->getErrors());
        }
        return $this->jsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }

    public function logoutAction(): JsonResponse
    {
        Auth::i()->logout();
        return $this->jsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }
}