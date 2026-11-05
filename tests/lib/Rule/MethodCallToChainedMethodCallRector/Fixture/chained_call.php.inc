<?php

namespace Ibexa\Rector\Tests\Rule\MethodCallToChainedMethodCallRector\Fixture;

use Ibexa\Contracts\ProductCatalog\Values\Price\Update\Struct\ProductPriceUpdateStruct;
use Ibexa\Contracts\ProductCatalog\Values\Price\Update\Struct\ProductPriceUpdateStructInterface;

final class ChainedCall
{
    public function viaInterface(ProductPriceUpdateStructInterface $struct): int
    {
        return $struct->getId();
    }

    public function viaImplementation(ProductPriceUpdateStruct $struct): int
    {
        return $struct->getId();
    }

    public function nullsafe(?ProductPriceUpdateStructInterface $struct): ?int
    {
        return $struct?->getId();
    }
}

?>
-----
<?php

namespace Ibexa\Rector\Tests\Rule\MethodCallToChainedMethodCallRector\Fixture;

use Ibexa\Contracts\ProductCatalog\Values\Price\Update\Struct\ProductPriceUpdateStruct;
use Ibexa\Contracts\ProductCatalog\Values\Price\Update\Struct\ProductPriceUpdateStructInterface;

final class ChainedCall
{
    public function viaInterface(ProductPriceUpdateStructInterface $struct): int
    {
        return $struct->getPrice()->getId();
    }

    public function viaImplementation(ProductPriceUpdateStruct $struct): int
    {
        return $struct->getPrice()->getId();
    }

    public function nullsafe(?ProductPriceUpdateStructInterface $struct): ?int
    {
        return $struct?->getPrice()->getId();
    }
}

?>
