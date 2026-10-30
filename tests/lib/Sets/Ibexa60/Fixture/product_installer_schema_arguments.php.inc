<?php

namespace Ibexa\Rector\Tests\Sets\Ibexa60\Fixture;

use Ibexa\Installer\Installer\AbstractProductInstaller;

final class CustomProductInstaller extends AbstractProductInstaller
{
    /**
     * @param iterable<object> $provisioners
     */
    public function __construct(object $db, object $schemaBuilder, bool $doctrineMigrationsEnabled, object $taggedMigrationsRunner, iterable $provisioners)
    {
        parent::__construct($db, $schemaBuilder, $doctrineMigrationsEnabled, $taggedMigrationsRunner, $provisioners);
    }
}

?>
-----
<?php

namespace Ibexa\Rector\Tests\Sets\Ibexa60\Fixture;

use Ibexa\Contracts\DoctrineSchema\SchemaAssetsFilterBypassInterface;
use Ibexa\Contracts\DoctrineSchema\DbPlatformFactoryInterface;
use Ibexa\Installer\Installer\AbstractProductInstaller;

final class CustomProductInstaller extends AbstractProductInstaller
{
    /**
     * @param iterable<object> $provisioners
     */
    public function __construct(object $db, object $schemaBuilder, bool $doctrineMigrationsEnabled, object $taggedMigrationsRunner, iterable $provisioners, SchemaAssetsFilterBypassInterface $schemaAssetsFilterBypass, DbPlatformFactoryInterface $dbPlatformFactory)
    {
        parent::__construct($db, $schemaBuilder, $schemaAssetsFilterBypass, $dbPlatformFactory, $doctrineMigrationsEnabled, $taggedMigrationsRunner, $provisioners);
    }
}

?>
