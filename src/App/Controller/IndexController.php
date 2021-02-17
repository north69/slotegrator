<?php

namespace App\Controller;

use Core\AbstractController;
use Core\Auth\Auth;
use Sweepstakes\Generator\GeneratorFactory;
use Symfony\Component\HttpFoundation\JsonResponse;

class IndexController extends AbstractController
{
    public function getAppConfigAction(): JsonResponse
    {
        $user = Auth::i()->getUser();
        $generators = (new GeneratorFactory($user->getId()))->getAvailableGenerators();
        return new JsonResponse([
            'prizes_are_available' => (bool)$generators,
            'user' => $user,
        ]);
    }
}