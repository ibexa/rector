<?php

namespace Ibexa\Rector\Tests\Sets\Ibexa60\Fixture;

use Ibexa\Core\Search\Legacy\Content\Common\Gateway\CriterionHandler\FieldBase;

final class CustomFieldCriterionHandler extends FieldBase
{
    public function __construct(object $connection, object $contentTypeHandler, object $languageHandler, private readonly object $converter)
    {
        parent::__construct($connection, $contentTypeHandler, $languageHandler);
    }
}

?>
-----
<?php

namespace Ibexa\Rector\Tests\Sets\Ibexa60\Fixture;

use Ibexa\Core\Persistence\Doctrine\JoinedTablesTracker;
use Ibexa\Core\Search\Legacy\Content\Common\Gateway\CriterionHandler\FieldBase;

final class CustomFieldCriterionHandler extends FieldBase
{
    public function __construct(object $connection, object $contentTypeHandler, object $languageHandler, private readonly object $converter, JoinedTablesTracker $joinedTablesTracker)
    {
        parent::__construct($connection, $contentTypeHandler, $languageHandler, $joinedTablesTracker);
    }
}

?>
