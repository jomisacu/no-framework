<?php

declare(strict_types=1);

namespace Jomisacu\NoFramework\Infrastructure;

use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class Application
{
    /**
     * @throws ControllerNotFoundException
     */
    public function handle(Request $request): Response
    {
        $controller = $this->getController($request);

        return $controller->__invoke($request);
    }

    public function getContainer(): ContainerInterface
    {
        $containerBuilder = new \DI\ContainerBuilder();
        $containerBuilder->useAutowiring(true);
        $containerBuilder->addDefinitions(APP_DIRECTORY . '/config/services.php');

        return $containerBuilder->build();
    }

    private function getController(Request $request)
    {
        $controllersByCommands = require APP_DIRECTORY.'/config/controllers.php';

        $controllerClass = $controllersByCommands[$request->get('command')] ?? null;

        if ($controllerClass === null) {
            throw new ControllerNotFoundException();
        }

        return $this->getContainer()->get($controllerClass);
    }
}