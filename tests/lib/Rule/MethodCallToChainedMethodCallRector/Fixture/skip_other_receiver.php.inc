<?php

namespace Ibexa\Rector\Tests\Rule\MethodCallToChainedMethodCallRector\Fixture;

use Ibexa\Contracts\ProductCatalog\Values\Price\Delete\Struct\ProductPriceDeleteStructInterface;
use Ibexa\Contracts\ProductCatalog\Values\Price\Update\Struct\ProductPriceUpdateStructInterface;
use Ibexa\Contracts\ProductCatalog\Values\PriceInterface;

final class SkipOtherReceiver
{
    public function price(PriceInterface $price): int
    {
        return $price->getId();
    }

    public function notConfigured(ProductPriceDeleteStructInterface $struct): int
    {
        return $struct->getId();
    }

    public function withArguments(ProductPriceUpdateStructInterface $struct): int
    {
        return $struct->getId(1);
    }
}

?>
