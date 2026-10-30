<?php

namespace Ibexa\Core\Search\Legacy\Content\Common\Gateway;

use Ibexa\Core\Persistence\Doctrine\JoinedTablesTracker;

abstract class CriterionHandler
{
    public function __construct(
        object $connection,
        JoinedTablesTracker $joinedTablesTracker
    ) {
    }
}
