<?php

namespace Ibexa\Rector\Tests\Rule\MethodCallToChainedMethodCallRector\Fixture;

use Ibexa\Contracts\ProductCatalog\Values\Price\Update\Struct\ProductPriceUpdateStructInterface;

final class FirstClassCallable
{
    public function idGetter(ProductPriceUpdateStructInterface $struct): \Closure
    {
        return $struct->getId(...);
    }
}

?>
-----
<?php

namespace Ibexa\Rector\Tests\Rule\MethodCallToChainedMethodCallRector\Fixture;

use Ibexa\Contracts\ProductCatalog\Values\Price\Update\Struct\ProductPriceUpdateStructInterface;

final class FirstClassCallable
{
    public function idGetter(ProductPriceUpdateStructInterface $struct): \Closure
    {
        return $struct->getPrice()->getId(...);
    }
}

?>
