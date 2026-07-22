<?php

namespace Rector\Tests\TypeDeclaration\Rector\ReplaceCartMoneyFactoryRector\Fixture;

use Ibexa\Cart\Money\MoneyFactory;

readonly class Foo
{
    private MoneyFactory $moneyFactory;

    public function __construct(MoneyFactory $moneyFactory)
    {
        $this->moneyFactory = $moneyFactory;
    }

    public function fooBar(MoneyFactory $moneyFactory): void
    {
    }
}

?>
-----
<?php

namespace Rector\Tests\TypeDeclaration\Rector\ReplaceCartMoneyFactoryRector\Fixture;

use Ibexa\ProductCatalog\Money\IntlMoneyFactory;

readonly class Foo
{
    private IntlMoneyFactory $moneyFactory;

    public function __construct(IntlMoneyFactory $moneyFactory)
    {
        $this->moneyFactory = $moneyFactory;
    }

    public function fooBar(IntlMoneyFactory $moneyFactory): void
    {
    }
}

?>
