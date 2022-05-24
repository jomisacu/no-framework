<?php

return [
    \PDO::class => \DI\create()->constructor(
        sprintf('mysql:dbname=%s;host=%s', $_ENV['DB_NAME'], $_ENV['DB_HOST']),
        $_ENV['DB_USER'],
        $_ENV['DB_PASS'],
        [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]
    ),
    Jomisacu\NoFramework\Domain\LocationRepositoryInterface::class => \DI\get(\Jomisacu\NoFramework\Infrastructure\LocationRepositoryMySql::class)
];