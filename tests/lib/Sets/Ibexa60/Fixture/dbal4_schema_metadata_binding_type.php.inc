<?php

namespace Ibexa\Rector\Tests\Sets\Ibexa60\Fixture;

use Doctrine\DBAL\ParameterType;
use Ibexa\Contracts\CorePersistence\Gateway\DoctrineSchemaMetadataInterface;

abstract class CustomSchemaMetadata implements DoctrineSchemaMetadataInterface
{
    public function getBindingTypeForColumn(string $columnName): int
    {
        return ParameterType::INTEGER;
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
        return ParameterType::INTEGER;
    }
}

?>
