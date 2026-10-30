<?php

namespace Ibexa\ProductCatalog\Local\Repository\Search\Legacy\Criterion;

abstract class SingleFieldAttributeVisitor
{
    protected function getCriterionBindType(object $criterion): \Doctrine\DBAL\ParameterType
    {
        throw new \LogicException('Stub');
    }
}
