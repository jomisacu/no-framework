<?php

declare(strict_types=1);

namespace Jomisacu\NoFramework\Application;

use Jomisacu\NoFramework\Domain\Location;
use Jomisacu\NoFramework\Domain\LocationRepositoryInterface;
use Jomisacu\NoFramework\Domain\MissingDeviceUuidException;
use Jomisacu\NoFramework\Domain\MissingLatException;
use Jomisacu\NoFramework\Domain\MissingLonException;

final class RegisterLocationAction
{
    private LocationRepositoryInterface $locationRepository;

    public function __construct(LocationRepositoryInterface $locationRepository)
    {
        $this->locationRepository = $locationRepository;
    }

    /**
     * @throws MissingLatException
     * @throws MissingLonException
     * @throws MissingDeviceUuidException
     */
    public function __invoke(string $deviceUuid, string $lat, string $lon)
    {
        $this->validate($deviceUuid, $lat, $lon);

        $location = new Location($deviceUuid, $lat, $lon);
        $this->locationRepository->save($location);
    }

    /**
     * @throws MissingLatException
     * @throws MissingLonException
     * @throws MissingDeviceUuidException
     */
    private function validate(string $deviceUuid, string $lat, string $lon)
    {
        if (empty($deviceUuid)) {
            throw new MissingDeviceUuidException();
        }

        if (empty($lat)) {
            throw new MissingLatException();
        }

        if (empty($lon)) {
            throw new MissingLonException();
        }
    }
}
