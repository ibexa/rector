<?php

namespace Ibexa\Contracts\ProductCatalog\Values\Price\Update\Struct;

interface ProductPriceUpdateStructInterface extends \Ibexa\Contracts\ProductCatalog\Values\Price\ProductPriceStructInterface
{
    public function getPrice(): \Ibexa\Contracts\ProductCatalog\Values\PriceInterface;
}
