<?php

namespace Ibexa\Rector\Tests\Rule\OptionsArrayToNamedArgumentsRector\Fixture;

use Ibexa\AdminUi\Validator\Constraints\LocationIsContainer;
use Ibexa\Cart\Validation\Constraint\ProductPriceCurrency;

final class OptionsArray
{
    #[LocationIsContainer(['message' => 'Not a container'])]
    public $location;

    public function constraints(object $cart): array
    {
        return [
            new LocationIsContainer(['message' => 'Not a container']),
            new LocationIsContainer(['message' => 'Not a container', 'groups' => 'Default']),
            new LocationIsContainer(['message' => 'Not a container'], ['Default']),
            new LocationIsContainer(options: ['payload' => 'x'], groups: ['Default']),
            new LocationIsContainer(null, ['Default']),
            new ProductPriceCurrency($cart, ['message' => 'Wrong currency']),
            new ProductPriceCurrency($cart, null, 'Wrong currency'),
            new ProductPriceCurrency($cart, ['groups' => ['Default']], payload: 'x'),
        ];
    }
}

?>
-----
<?php

namespace Ibexa\Rector\Tests\Rule\OptionsArrayToNamedArgumentsRector\Fixture;

use Ibexa\AdminUi\Validator\Constraints\LocationIsContainer;
use Ibexa\Cart\Validation\Constraint\ProductPriceCurrency;

final class OptionsArray
{
    #[LocationIsContainer(message: 'Not a container')]
    public $location;

    public function constraints(object $cart): array
    {
        return [
            new LocationIsContainer(message: 'Not a container'),
            new LocationIsContainer(message: 'Not a container', groups: ['Default']),
            new LocationIsContainer(message: 'Not a container', groups: ['Default']),
            new LocationIsContainer(groups: ['Default'], payload: 'x'),
            new LocationIsContainer(groups: ['Default']),
            new ProductPriceCurrency($cart, message: 'Wrong currency'),
            new ProductPriceCurrency($cart, 'Wrong currency'),
            new ProductPriceCurrency($cart, groups: ['Default'], payload: 'x'),
        ];
    }
}

?>
