<?php

namespace Sweepstakes\Controller;

use Core\AbstractController;
use Core\ApiControllerTrait;
use Core\Auth\Auth;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class PrizeController extends AbstractController
{
    use ApiControllerTrait;

    public function beforeAction(): ?Response
    {
        if (Auth::i()->getUser()->isGuest()) {
            return $this->jsonErrorResponse(Response::HTTP_UNAUTHORIZED);
        }
        return parent::beforeAction();
    }

    public function generateAction(): JsonResponse
    {
        return $this->jsonResponse(null, Response::HTTP_CREATED);
    }

    public function getListAction(): JsonResponse
    {
        return $this->jsonResponse([
            [
                'user_id' => 1,
                'type' => 'money',
                'title' => '100$',
                'description' => 'One hundred dollars'
            ]
        ]);
    }
}