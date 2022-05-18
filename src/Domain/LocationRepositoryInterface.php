<?php

declare(strict_types=1);

namespace Jomisacu\NoFramework\Domain;

interface LocationRepositoryInterface
{
    public function save(Location $location): void;
}