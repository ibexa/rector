<?php

namespace Ibexa\Bundle\RepositoryInstaller\Installer;

use Ibexa\Contracts\DoctrineSchema\DbPlatformFactoryInterface;

class CoreInstaller
{
    public function __construct(
        object $db,
        object $schemaBuilder,
        DbPlatformFactoryInterface $dbPlatformFactory,
        bool $doctrineMigrationsEnabled,
        ?object $taggedMigrationsRunner = null
    ) {
    }
}
