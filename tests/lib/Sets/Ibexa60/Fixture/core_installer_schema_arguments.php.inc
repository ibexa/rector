<?php

namespace Ibexa\Rector\Tests\Sets\Ibexa60\Fixture;

use Ibexa\Bundle\RepositoryInstaller\Installer\CoreInstaller;

final class CustomInstaller extends CoreInstaller
{
    public function __construct(object $db, object $schemaBuilder, bool $doctrineMigrationsEnabled, ?object $taggedMigrationsRunner = null)
    {
        parent::__construct($db, $schemaBuilder, $doctrineMigrationsEnabled, $taggedMigrationsRunner);
    }
}

?>
-----
<?php

namespace Ibexa\Rector\Tests\Sets\Ibexa60\Fixture;

use Ibexa\Bundle\RepositoryInstaller\Installer\CoreInstaller;

final class CustomInstaller extends CoreInstaller
{
    public function __construct(object $db, ?object $taggedMigrationsRunner = null)
    {
        parent::__construct($db, $taggedMigrationsRunner);
    }
}

?>
