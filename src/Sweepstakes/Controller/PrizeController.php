<?php

namespace Sweepstakes\Controller;

use Core\AbstractController;
use Core\ApiControllerTrait;
use Core\Auth\Auth;
use Sweepstakes\DataProvider\PrizeListDataProvider;
use Sweepstakes\EventHandler\PrizeCreateEventHandler;
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
        $user_id = Auth::i()->getUser()->getId();
        $handler = new PrizeCreateEventHandler();
        if (!$handler->handle($user_id)) {
            return $this->jsonErrorResponse(Response::HTTP_BAD_REQUEST);
        }
        return $this->jsonResponse(null, Response::HTTP_CREATED);
    }

    public function getListAction(): JsonResponse
    {
        $user_id = Auth::i()->getUser()->getId();
        $data = (new PrizeListDataProvider($user_id))->getData();
        return $this->jsonResponse($data);
    }
}