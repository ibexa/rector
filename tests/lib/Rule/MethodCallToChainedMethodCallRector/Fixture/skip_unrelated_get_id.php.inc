<?php

namespace Ibexa\Rector\Tests\Rule\MethodCallToChainedMethodCallRector\Fixture;

use Ibexa\Contracts\ProductCatalog\Values\Price\ProductPriceStructInterface;

final class UnrelatedStruct
{
    public function getId(): int
    {
        return 1;
    }
}

final class SkipUnrelatedGetId
{
    public function unrelatedObject(UnrelatedStruct $struct): int
    {
        return $struct->getId();
    }

    public function untyped($struct): int
    {
        return $struct->getId();
    }

    public function parentInterface(ProductPriceStructInterface $struct): int
    {
        return $struct->getId();
    }
}

?>
