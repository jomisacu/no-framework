<?php

declare(strict_types=1);

namespace Infrastructure;

use Jomisacu\NoFramework\Domain\Location;
use Jomisacu\NoFramework\Infrastructure\LocationRepositoryMySql;

final class LocationRepositoryMysqlTest extends \PHPUnit\Framework\TestCase
{
    public function testSave()
    {
        $repository = $this->getRepository();

        $location = $this->getLocationObject();

        $repository->save($location);

        $this->assertTrue($this->existsInDatabaseMySql($location), 'El objeto no existe en la base de datos mysql');

        $this->deleteLocationObject($location);
    }

    private function getRepository(): LocationRepositoryMySql
    {
        return new LocationRepositoryMySql($this->getPdo());
    }

    private function getPdo(): \PDO
    {
        $dsn = sprintf('mysql:dbname=%s;host=%s', $_ENV['DB_NAME'], $_ENV['DB_HOST']);

        return new \PDO($dsn, $_ENV['DB_USER'], $_ENV['DB_PASS'], [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
        ]);
    }

    private function getLocationObject(): Location
    {
        return new Location(
            "860bec84-2e61-4d75-b979-ff72daaad8cc",
            '12.1111',
            '12.1111'
        );
    }

    private function existsInDatabaseMySql(Location $location): bool
    {
        $statement = $this->getPdo()->prepare('
            SELECT * 
            FROM locations 
            WHERE device_uuid = ? AND lat = ? AND lon = ?
        ');
        $statement->execute([
            $location->getDeviceUuid(),
            $location->getLat(),
            $location->getlon()
        ]);

        return $statement->rowCount() == 1;
    }

    protected function deleteLocationObject(Location $location): void
    {
        $this->getPdo()->prepare(
            '
            DELETE FROM locations WHERE device_uuid = ?
        '
        )->execute([
            $location->getDeviceUuid()
        ]);
    }
}