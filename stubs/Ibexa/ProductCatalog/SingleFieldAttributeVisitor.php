<?php

namespace Ibexa\ProductCatalog\Local\Repository\Search\Legacy\Criterion;

use Doctrine\DBAL\ParameterType;
use Ibexa\Contracts\ProductCatalog\Values\Product\Query\Criterion\AbstractAttribute;

abstract class SingleFieldAttributeVisitor
{
    protected function getCriterionBindType(AbstractAttribute $criterion): ParameterType
    {
        return ParameterType::STRING;
    }
}
