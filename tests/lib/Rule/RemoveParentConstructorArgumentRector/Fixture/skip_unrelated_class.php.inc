<?php

abstract class SomeInstallerBase
{
    public function __construct(object $db)
    {
    }
}

final class UnrelatedInstaller extends SomeInstallerBase
{
    public function __construct(object $db, object $schemaBuilder, bool $doctrineMigrationsEnabled)
    {
        parent::__construct($db, $schemaBuilder, $doctrineMigrationsEnabled);
    }
}

?>
