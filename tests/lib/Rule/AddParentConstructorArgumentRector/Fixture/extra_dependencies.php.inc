<?php

use Ibexa\Core\Search\Legacy\Content\Common\Gateway\CriterionHandler;

final class ExtraDependencies extends CriterionHandler
{
    public function __construct(
        object $connection,
        private readonly \stdClass $service,
        string $prefix = 'foo',
        object ...$rest
    ) {
        parent::__construct($connection);
    }
}

?>
-----
<?php

use Ibexa\Core\Search\Legacy\Content\Common\Gateway\CriterionHandler;

final class ExtraDependencies extends CriterionHandler
{
    public function __construct(
        object $connection,
        private readonly \stdClass $service,
        \Ibexa\Core\Persistence\Doctrine\JoinedTablesTracker $joinedTablesTracker,
        string $prefix = 'foo',
        object ...$rest
    ) {
        parent::__construct($connection, $joinedTablesTracker);
    }
}

?>
