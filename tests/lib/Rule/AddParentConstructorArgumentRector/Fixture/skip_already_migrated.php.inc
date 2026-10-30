<?php

use Ibexa\Core\Persistence\Doctrine\JoinedTablesTracker;
use Ibexa\Core\Search\Legacy\Content\Common\Gateway\CriterionHandler;

final class AlreadyMigrated extends CriterionHandler
{
    public function __construct(object $connection, JoinedTablesTracker $tracker)
    {
        parent::__construct($connection, $tracker);
    }
}

?>
