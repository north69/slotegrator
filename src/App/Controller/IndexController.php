<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;

class IndexController
{
    public function getAppConfigAction(): JsonResponse
    {
        return new JsonResponse([
            'prizes_are_available' => true,
            'user' => null,
        ]);
    }
}