<?php

require __DIR__ . '/bootstrap.php';

$containerBuilder = new \DI\ContainerBuilder();
$containerBuilder->useAutowiring(true);
$containerBuilder->addDefinitions(__DIR__.'/config/services.php');
$container = $containerBuilder->build();

echo get_class($container->get(\Jomisacu\NoFramework\Domain\LocationRepositoryInterface::class)) . "\n";