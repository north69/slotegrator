<?php

use Symfony\Component\HttpFoundation\Request;

require dirname(__DIR__).'/config/bootstrap.php';

$kernel = new \Core\HttpKernel();
$response = $kernel->handleRequest(Request::createFromGlobals());
$response->send();
