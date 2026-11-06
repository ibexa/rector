<?php

namespace Ibexa\Installer\Installer;

use Ibexa\Bundle\RepositoryInstaller\Installer\CoreInstaller;
use Ibexa\Contracts\DoctrineSchema\DbPlatformFactoryInterface;

abstract class AbstractProductInstaller extends CoreInstaller
{
    /**
     * @param iterable<object> $provisioners
     */
    public function __construct(
        object $db,
        object $schemaBuilder,
        DbPlatformFactoryInterface $dbPlatformFactory,
        bool $doctrineMigrationsEnabled,
        object $taggedMigrationsRunner,
        iterable $provisioners
    ) {
        parent::__construct($db, $schemaBuilder, $dbPlatformFactory, $doctrineMigrationsEnabled, $taggedMigrationsRunner);
    }
}
