<?php

namespace Ibexa\Rector\Tests\Sets\Ibexa60\Fixture;

use Ibexa\Measurement\ProductCatalog\Form\Attribute\Search\Criterion\AbstractMeasurementAttributeVisitor;

final class CustomMeasurementAttributeVisitor extends AbstractMeasurementAttributeVisitor
{
    public function __construct(object $connection, object $unitConverter)
    {
        parent::__construct($connection, $unitConverter);
    }
}

?>
-----
<?php

namespace Ibexa\Rector\Tests\Sets\Ibexa60\Fixture;

use Ibexa\Core\Persistence\Doctrine\JoinedTablesTracker;
use Ibexa\Measurement\ProductCatalog\Form\Attribute\Search\Criterion\AbstractMeasurementAttributeVisitor;

final class CustomMeasurementAttributeVisitor extends AbstractMeasurementAttributeVisitor
{
    public function __construct(object $connection, object $unitConverter, JoinedTablesTracker $joinedTablesTracker)
    {
        parent::__construct($connection, $unitConverter, $joinedTablesTracker);
    }
}

?>
