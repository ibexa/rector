<?php

use Ibexa\Bundle\RepositoryInstaller\Installer\CoreInstaller;

final class RemovedArguments extends CoreInstaller
{
    public function __construct(object $db, object $schemaBuilder, bool $doctrineMigrationsEnabled, ?object $taggedMigrationsRunner = null)
    {
        parent::__construct($db, $schemaBuilder, $doctrineMigrationsEnabled, $taggedMigrationsRunner);
    }
}

?>
-----
<?php

use Ibexa\Bundle\RepositoryInstaller\Installer\CoreInstaller;

final class RemovedArguments extends CoreInstaller
{
    public function __construct(object $db, ?object $taggedMigrationsRunner = null)
    {
        parent::__construct($db, $taggedMigrationsRunner);
    }
}

?>
