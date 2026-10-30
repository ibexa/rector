<?php

use Ibexa\Core\Search\Legacy\Content\Common\Gateway\CriterionHandler;

final class NamedArguments extends CriterionHandler
{
    public function __construct(object $db)
    {
        parent::__construct(connection: $db);
    }
}

?>
-----
<?php

use Ibexa\Core\Search\Legacy\Content\Common\Gateway\CriterionHandler;

final class NamedArguments extends CriterionHandler
{
    public function __construct(object $db, \Ibexa\Core\Persistence\Doctrine\JoinedTablesTracker $joinedTablesTracker)
    {
        parent::__construct(connection: $db, joinedTablesTracker: $joinedTablesTracker);
    }
}

?>
