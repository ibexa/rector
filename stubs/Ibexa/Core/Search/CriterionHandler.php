<?php

namespace Ibexa\Core\Persistence\Doctrine;

final class JoinedTablesTracker
{
}

namespace Ibexa\Core\Search\Legacy\Content\Common\Gateway;

abstract class CriterionHandler
{
    public function __construct(
        object $connection,
        \Ibexa\Core\Persistence\Doctrine\JoinedTablesTracker $joinedTablesTracker
    ) {
    }
}
