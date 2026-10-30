<?php

namespace Ibexa\Rector\Tests\Sets\Ibexa60\Fixture;

use Ibexa\ProductCatalog\Local\Repository\Search\Legacy\Criterion\SingleFieldAttributeVisitor;

final class CustomAttributeVisitor extends SingleFieldAttributeVisitor
{
    protected function getCriterionBindType(object $criterion): int
    {
        return 1;
    }
}

?>
-----
<?php

namespace Ibexa\Rector\Tests\Sets\Ibexa60\Fixture;

use Doctrine\DBAL\ParameterType;
use Ibexa\ProductCatalog\Local\Repository\Search\Legacy\Criterion\SingleFieldAttributeVisitor;

final class CustomAttributeVisitor extends SingleFieldAttributeVisitor
{
    protected function getCriterionBindType(object $criterion): ParameterType
    {
        return 1;
    }
}

?>
