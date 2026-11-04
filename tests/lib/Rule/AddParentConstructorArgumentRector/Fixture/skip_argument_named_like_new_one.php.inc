<?php

use Ibexa\Core\Search\Legacy\Content\Common\Gateway\CriterionHandler;

final class ArgumentNamedLikeNewOne extends CriterionHandler
{
    public function __construct(object $connection, object $joinedTablesTracker)
    {
        parent::__construct($connection, $joinedTablesTracker);
    }
}

?>
