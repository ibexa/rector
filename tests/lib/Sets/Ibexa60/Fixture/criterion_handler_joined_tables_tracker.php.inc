<?php

namespace Ibexa\Rector\Tests\Sets\Ibexa60\Fixture;

use Ibexa\Core\Search\Legacy\Content\Common\Gateway\CriterionHandler;

final class CustomCriterionHandler extends CriterionHandler
{
    public function __construct(object $connection)
    {
        parent::__construct($connection);
    }
}

?>
-----
<?php

namespace Ibexa\Rector\Tests\Sets\Ibexa60\Fixture;

use Ibexa\Core\Persistence\Doctrine\JoinedTablesTracker;
use Ibexa\Core\Search\Legacy\Content\Common\Gateway\CriterionHandler;

final class CustomCriterionHandler extends CriterionHandler
{
    public function __construct(object $connection, JoinedTablesTracker $joinedTablesTracker)
    {
        parent::__construct($connection, $joinedTablesTracker);
    }
}

?>
