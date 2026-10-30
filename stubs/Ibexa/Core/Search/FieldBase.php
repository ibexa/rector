<?php

namespace Ibexa\Core\Search\Legacy\Content\Common\Gateway\CriterionHandler;

use Ibexa\Core\Persistence\Doctrine\JoinedTablesTracker;
use Ibexa\Core\Search\Legacy\Content\Common\Gateway\CriterionHandler;

abstract class FieldBase extends CriterionHandler
{
    public function __construct(
        object $connection,
        object $contentTypeHandler,
        object $languageHandler,
        JoinedTablesTracker $joinedTablesTracker
    ) {
        parent::__construct($connection, $joinedTablesTracker);
    }
}
