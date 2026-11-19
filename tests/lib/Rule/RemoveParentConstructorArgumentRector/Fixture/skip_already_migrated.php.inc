<?php

use Ibexa\Bundle\RepositoryInstaller\Installer\CoreInstaller;

final class AlreadyMigratedInstaller extends CoreInstaller
{
    public function __construct(object $db, ?object $taggedMigrationsRunner = null)
    {
        parent::__construct($db, $taggedMigrationsRunner);
    }
}

?>
