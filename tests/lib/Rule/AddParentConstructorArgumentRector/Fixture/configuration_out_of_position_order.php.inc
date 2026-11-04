<?php

use Ibexa\Bundle\RepositoryInstaller\Installer\CoreInstaller;

final class OutOfOrderInstaller extends CoreInstaller
{
    public function __construct(object $db, object $schemaBuilder, bool $doctrineMigrationsEnabled)
    {
        parent::__construct($db, $schemaBuilder, $doctrineMigrationsEnabled);
    }
}

?>
-----
<?php

use Ibexa\Bundle\RepositoryInstaller\Installer\CoreInstaller;

final class OutOfOrderInstaller extends CoreInstaller
{
    public function __construct(object $db, object $schemaBuilder, bool $doctrineMigrationsEnabled, \Ibexa\Contracts\DoctrineSchema\SchemaAssetsFilterBypassInterface $schemaAssetsFilterBypass, \Ibexa\Contracts\DoctrineSchema\DbPlatformFactoryInterface $dbPlatformFactory)
    {
        parent::__construct($db, $schemaBuilder, $schemaAssetsFilterBypass, $dbPlatformFactory, $doctrineMigrationsEnabled);
    }
}

?>
