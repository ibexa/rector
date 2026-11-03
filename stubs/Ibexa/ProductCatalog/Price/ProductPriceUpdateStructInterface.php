<?php

namespace Ibexa\Contracts\ProductCatalog\Values\Price\Update\Struct;

interface ProductPriceUpdateStructInterface
{
    public function getPrice(): \Ibexa\Contracts\ProductCatalog\Values\PriceInterface;
}
