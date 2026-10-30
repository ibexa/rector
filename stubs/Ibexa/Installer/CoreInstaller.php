<?php

namespace Ibexa\Bundle\RepositoryInstaller\Installer;

use Ibexa\Contracts\DoctrineSchema\DbPlatformFactoryInterface;
use Ibexa\Contracts\DoctrineSchema\SchemaAssetsFilterBypassInterface;

class CoreInstaller
{
    public function __construct(
        object $db,
        object $schemaBuilder,
        SchemaAssetsFilterBypassInterface $schemaAssetsFilterBypass,
        DbPlatformFactoryInterface $dbPlatformFactory,
        bool $doctrineMigrationsEnabled,
        ?object $taggedMigrationsRunner = null
    ) {
    }
}
