<?php

namespace Ibexa\Contracts\CorePersistence\Gateway;

use Doctrine\DBAL\ParameterType;

interface DoctrineSchemaMetadataInterface
{
    public function getBindingTypeForColumn(string $columnName): ParameterType;
}
