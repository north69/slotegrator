<?php

namespace Core;

use Symfony\Component\HttpFoundation\Response;

class AbstractController
{
    public function beforeAction(): ?Response
    {
        return null;
    }
}