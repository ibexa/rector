<?php

use Ibexa\Core\Search\Legacy\Content\Common\Gateway\CriterionHandler;

abstract class IntermediateWithoutConstructor extends CriterionHandler
{
}

final class ExtendsIntermediate extends IntermediateWithoutConstructor
{
    public function __construct(object $connection)
    {
        parent::__construct($connection);
    }
}

?>
-----
<?php

use Ibexa\Core\Search\Legacy\Content\Common\Gateway\CriterionHandler;

abstract class IntermediateWithoutConstructor extends CriterionHandler
{
}

final class ExtendsIntermediate extends IntermediateWithoutConstructor
{
    public function __construct(object $connection, \Ibexa\Core\Persistence\Doctrine\JoinedTablesTracker $joinedTablesTracker)
    {
        parent::__construct($connection, $joinedTablesTracker);
    }
}

?>
