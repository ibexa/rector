<?php

namespace Ibexa\Contracts\ProductCatalog\Values\Price\Delete\Struct;

interface ProductPriceDeleteStructInterface extends \Ibexa\Contracts\ProductCatalog\Values\Price\ProductPriceStructInterface
{
    public function getPrice(): \Ibexa\Contracts\ProductCatalog\Values\PriceInterface;
}
