<?php

namespace Ibexa\Rector\Tests\Rule\MethodCallToChainedMethodCallRector\Fixture;

use Ibexa\Contracts\ProductCatalog\Values\Price\Delete\Struct\ProductPriceDeleteStructInterface;
use Ibexa\Contracts\ProductCatalog\Values\Price\Update\Struct\ProductPriceUpdateStructInterface;

final class UnionReceiver
{
    public function id(ProductPriceUpdateStructInterface|ProductPriceDeleteStructInterface $struct): int
    {
        return $struct->getId();
    }
}

?>
-----
<?php

namespace Ibexa\Rector\Tests\Rule\MethodCallToChainedMethodCallRector\Fixture;

use Ibexa\Contracts\ProductCatalog\Values\Price\Delete\Struct\ProductPriceDeleteStructInterface;
use Ibexa\Contracts\ProductCatalog\Values\Price\Update\Struct\ProductPriceUpdateStructInterface;

final class UnionReceiver
{
    public function id(ProductPriceUpdateStructInterface|ProductPriceDeleteStructInterface $struct): int
    {
        return $struct->getPrice()->getId();
    }
}

?>
