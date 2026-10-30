<?php

namespace Ibexa\Installer\Installer;

use Ibexa\Bundle\RepositoryInstaller\Installer\CoreInstaller;
use Ibexa\Contracts\DoctrineSchema\DbPlatformFactoryInterface;
use Ibexa\Contracts\DoctrineSchema\SchemaAssetsFilterBypassInterface;

abstract class AbstractProductInstaller extends CoreInstaller
{
    /**
     * @param iterable<object> $provisioners
     */
    public function __construct(
        object $db,
        object $schemaBuilder,
        SchemaAssetsFilterBypassInterface $schemaAssetsFilterBypass,
        DbPlatformFactoryInterface $dbPlatformFactory,
        bool $doctrineMigrationsEnabled,
        object $taggedMigrationsRunner,
        iterable $provisioners
    ) {
        parent::__construct($db, $schemaBuilder, $schemaAssetsFilterBypass, $dbPlatformFactory, $doctrineMigrationsEnabled, $taggedMigrationsRunner);
    }
}
