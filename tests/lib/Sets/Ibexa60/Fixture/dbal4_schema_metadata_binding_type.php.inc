<?php

namespace Ibexa\Rector\Tests\Sets\Ibexa60\Fixture;

use Ibexa\Contracts\CorePersistence\Gateway\DoctrineSchemaMetadataInterface;

abstract class CustomSchemaMetadata implements DoctrineSchemaMetadataInterface
{
    public function getBindingTypeForColumn(string $columnName): int
    {
        return 2;
    }
}

?>
-----
<?php

namespace Ibexa\Rector\Tests\Sets\Ibexa60\Fixture;

use Doctrine\DBAL\ParameterType;
use Ibexa\Contracts\CorePersistence\Gateway\DoctrineSchemaMetadataInterface;

abstract class CustomSchemaMetadata implements DoctrineSchemaMetadataInterface
{
    public function getBindingTypeForColumn(string $columnName): ParameterType
    {
        return 2;
    }
}

?>
