<?php

use Ibexa\Bundle\RepositoryInstaller\Installer\CoreInstaller;

final class InstallerWithNamedArguments extends CoreInstaller
{
    public function __construct(object $db, object $schemaBuilder, ?object $taggedMigrationsRunner = null)
    {
        parent::__construct(
            db: $db,
            schemaBuilder: $schemaBuilder,
            doctrineMigrationsEnabled: true,
            taggedMigrationsRunner: $taggedMigrationsRunner
        );
    }
}

?>
-----
<?php

use Ibexa\Bundle\RepositoryInstaller\Installer\CoreInstaller;

final class InstallerWithNamedArguments extends CoreInstaller
{
    public function __construct(object $db, ?object $taggedMigrationsRunner = null)
    {
        parent::__construct(
            db: $db,
            taggedMigrationsRunner: $taggedMigrationsRunner
        );
    }
}

?>
