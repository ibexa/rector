<?php

namespace Ibexa\Measurement\ProductCatalog\Form\Attribute\Search\Criterion;

use Ibexa\Core\Persistence\Doctrine\JoinedTablesTracker;

abstract class AbstractMeasurementAttributeVisitor
{
    public function __construct(
        object $connection,
        object $unitConverter,
        JoinedTablesTracker $joinedTablesTracker
    ) {
    }
}
