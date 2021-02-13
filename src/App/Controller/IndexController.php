<?php

namespace App\Controller;

use Core\Auth\Auth;
use Symfony\Component\HttpFoundation\JsonResponse;

class IndexController
{
    public function getAppConfigAction(): JsonResponse
    {
        $user = Auth::i()->getUser();
        return new JsonResponse([
            'prizes_are_available' => true,
            'user' => $user,
        ]);
    }
}