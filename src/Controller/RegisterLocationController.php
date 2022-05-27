<?php

declare(strict_types=1);

namespace Jomisacu\NoFramework\Controller;

use Jomisacu\NoFramework\Application\RegisterLocationAction;
use Jomisacu\NoFramework\Infrastructure\ControllerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class RegisterLocationController implements ControllerInterface
{
    private RegisterLocationAction $registerLocationAction;

    public function __construct(RegisterLocationAction $registerLocationAction)
    {
        $this->registerLocationAction = $registerLocationAction;
    }

    public function __invoke(Request $request): Response
    {
        try {
            $this->registerLocationAction->__invoke(
                $request->get('device_uuid'),
                $request->get('lat'),
                $request->get('lon')
            );
        } catch (\Exception $exception) {
            return new Response('Wrong location data', 400);
        }

        return new Response();
    }
}