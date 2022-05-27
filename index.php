<?php

use Jomisacu\NoFramework\Infrastructure\Application;
use Symfony\Component\HttpFoundation\Request;

require __DIR__ . '/bootstrap.php';

$application = new Application();
$request = Request::createFromGlobals();
$response = $application->handle($request);

$response->send();
