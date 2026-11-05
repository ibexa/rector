<?php

namespace Ibexa\Rector\Tests\Sets\Ibexa60\Fixture;

use Ibexa\Contracts\ProductCatalog\Values\Price\Delete\Struct\ProductPriceDeleteStruct;
use Ibexa\Contracts\ProductCatalog\Values\Price\Update\Struct\ProductPriceUpdateStructInterface;

final class ProductPriceStructGetId
{
    public function update(ProductPriceUpdateStructInterface $struct): int
    {
        return $struct->getId();
    }

    public function delete(ProductPriceDeleteStruct $struct): int
    {
        return $struct->getId();
    }
}

?>
-----
<?php

namespace Ibexa\Rector\Tests\Sets\Ibexa60\Fixture;

use Ibexa\Contracts\ProductCatalog\Values\Price\Delete\Struct\ProductPriceDeleteStruct;
use Ibexa\Contracts\ProductCatalog\Values\Price\Update\Struct\ProductPriceUpdateStructInterface;

final class ProductPriceStructGetId
{
    public function update(ProductPriceUpdateStructInterface $struct): int
    {
        return $struct->getPrice()->getId();
    }

    public function delete(ProductPriceDeleteStruct $struct): int
    {
        return $struct->getPrice()->getId();
    }
}

?>
