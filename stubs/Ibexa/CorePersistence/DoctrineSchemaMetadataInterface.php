<?php

namespace Ibexa\Contracts\CorePersistence\Gateway;

interface DoctrineSchemaMetadataInterface
{
    public function getBindingTypeForColumn(string $columnName): \Doctrine\DBAL\ParameterType;
}
