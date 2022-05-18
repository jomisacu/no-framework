<?php

declare(strict_types=1);

namespace Jomisacu\NoFramework\Tests\Application;

use Jomisacu\NoFramework\Application\RegisterLocationAction;
use Jomisacu\NoFramework\Domain\LocationRepositoryInterface;
use Jomisacu\NoFramework\Domain\MissingDeviceUuidException;
use Jomisacu\NoFramework\Domain\MissingLatException;
use Jomisacu\NoFramework\Domain\MissingLonException;

final class RegisterLocationActionTest extends \PHPUnit\Framework\TestCase
{
    public function testMissingDeviceUuidExceptionIsThrown()
    {
        $registerLocationAction = new RegisterLocationAction($this->getLocationRepository());

        $this->expectException(MissingDeviceUuidException::class);

        $registerLocationAction->__invoke("", "", "");
    }

    public function testMissingLatExceptionIsThrown()
    {
        $registerLocationAction = new RegisterLocationAction($this->getLocationRepository());

        $this->expectException(MissingLatException::class);

        $registerLocationAction->__invoke("49f3ec1b-d4ef-467f-87fa-352e0956e7b8", "", "");
    }

    public function testMissingLonExceptionIsThrown()
    {
        $registerLocationAction = new RegisterLocationAction($this->getLocationRepository());

        $this->expectException(MissingLonException::class);

        $registerLocationAction->__invoke("49f3ec1b-d4ef-467f-87fa-352e0956e7b8", "88.7777", "");
    }

    public function testRegisterLocationActionFlow()
    {
        $locationRepository = $this->getLocationRepository();
        $locationRepository->expects($this->once())->method('save');
        $registerLocationAction = new RegisterLocationAction($locationRepository);

        $registerLocationAction->__invoke("49f3ec1b-d4ef-467f-87fa-352e0956e7b8", "88.7777", "77.8766");
    }

    /**
     * @return LocationRepositoryInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    private function getLocationRepository()
    {
        return $this->createMock(LocationRepositoryInterface::class);
    }
}