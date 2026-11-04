<?php

use Ibexa\Core\Persistence\Doctrine\JoinedTablesTracker;
use Ibexa\Core\Search\Legacy\Content\Common\Gateway\CriterionHandler;

final class ExistingParam extends CriterionHandler
{
    public function __construct(object $connection, private readonly JoinedTablesTracker $joinedTablesTracker)
    {
        parent::__construct($connection);
    }
}

?>
-----
<?php

use Ibexa\Core\Persistence\Doctrine\JoinedTablesTracker;
use Ibexa\Core\Search\Legacy\Content\Common\Gateway\CriterionHandler;

final class ExistingParam extends CriterionHandler
{
    public function __construct(object $connection, private readonly JoinedTablesTracker $joinedTablesTracker)
    {
        parent::__construct($connection, $joinedTablesTracker);
    }
}

?>
