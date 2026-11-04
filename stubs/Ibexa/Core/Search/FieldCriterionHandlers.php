<?php

namespace Ibexa\Core\Search\Legacy\Content\Common\Gateway\CriterionHandler;

use Ibexa\Core\Persistence\Doctrine\JoinedTablesTracker;
use Ibexa\Core\Search\Legacy\Content\Common\Gateway\CriterionHandler;

class Field extends FieldBase
{
    public function __construct(
        object $connection,
        object $contentTypeHandler,
        object $languageHandler,
        object $fieldConverterRegistry,
        object $fieldValueConverter,
        object $transformationProcessor,
        JoinedTablesTracker $joinedTablesTracker
    ) {
    }
}

class FieldEmpty extends FieldBase
{
    public function __construct(
        object $connection,
        object $contentTypeHandler,
        object $languageHandler,
        object $fieldConverterRegistry,
        object $fieldTypeService,
        JoinedTablesTracker $joinedTablesTracker
    ) {
    }
}

class FullText extends CriterionHandler
{
    public function __construct(
        object $connection,
        object $processor,
        object $languageMaskGenerator,
        JoinedTablesTracker $joinedTablesTracker,
        array $configuration = []
    ) {
    }
}
