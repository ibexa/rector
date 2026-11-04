<?php

namespace Ibexa\Rector\Tests\Sets\Ibexa60\Fixture;

use Doctrine\DBAL\ParameterType;
use Ibexa\Contracts\ProductCatalog\Values\Product\Query\Criterion\AbstractAttribute;
use Ibexa\ProductCatalog\Local\Repository\Search\Legacy\Criterion\SingleFieldAttributeVisitor;

final class CustomAttributeVisitor extends SingleFieldAttributeVisitor
{
    protected function getCriterionBindType(AbstractAttribute $criterion): int
    {
        return ParameterType::INTEGER;
    }
}

?>
-----
<?php

namespace Ibexa\Rector\Tests\Sets\Ibexa60\Fixture;

use Doctrine\DBAL\ParameterType;
use Ibexa\Contracts\ProductCatalog\Values\Product\Query\Criterion\AbstractAttribute;
use Ibexa\ProductCatalog\Local\Repository\Search\Legacy\Criterion\SingleFieldAttributeVisitor;

final class CustomAttributeVisitor extends SingleFieldAttributeVisitor
{
    protected function getCriterionBindType(AbstractAttribute $criterion): ParameterType
    {
        return ParameterType::INTEGER;
    }
}

?>
