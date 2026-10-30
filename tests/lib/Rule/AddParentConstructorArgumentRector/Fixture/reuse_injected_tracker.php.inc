<?php

use Ibexa\Core\Persistence\Doctrine\JoinedTablesTracker;
use Ibexa\Core\Search\Legacy\Content\Common\Gateway\CriterionHandler;

final class ReuseInjectedTracker extends CriterionHandler
{
    public function __construct(object $connection, private readonly JoinedTablesTracker $tracker)
    {
        parent::__construct($connection);
    }
}

?>
-----
<?php

use Ibexa\Core\Persistence\Doctrine\JoinedTablesTracker;
use Ibexa\Core\Search\Legacy\Content\Common\Gateway\CriterionHandler;

final class ReuseInjectedTracker extends CriterionHandler
{
    public function __construct(object $connection, private readonly JoinedTablesTracker $tracker)
    {
        parent::__construct($connection, $tracker);
    }
}

?>
