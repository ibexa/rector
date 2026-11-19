<?php

namespace Ibexa\Installer\Installer;

use Ibexa\Bundle\RepositoryInstaller\Installer\CoreInstaller;

abstract class AbstractProductInstaller extends CoreInstaller
{
    /**
     * @param iterable<object> $provisioners
     */
    public function __construct(
        object $db,
        object $taggedMigrationsRunner,
        iterable $provisioners
    ) {
        parent::__construct($db, $taggedMigrationsRunner);
    }
}
