<?php

namespace Ibexa\Rector\Tests\Rule\OptionsArrayToNamedArgumentsRector\Fixture;

use Ibexa\AdminUi\Validator\Constraints\LocationIsContainer;
use Ibexa\Cart\Validation\Constraint\ProductPriceCurrency;

final class OptionsArray
{
    #[LocationIsContainer(['message' => 'Not a container'])]
    public $location;

    private const GROUPS = ['Default'];

    public function constraints(object $cart, array $groups): array
    {
        return [
            new LocationIsContainer(['message' => 'Not a container']),
            new LocationIsContainer(['message' => 'Not a container', 'groups' => 'Default']),
            new LocationIsContainer(['message' => 'Not a container'], ['Default']),
            new LocationIsContainer(options: ['payload' => 'x'], groups: ['Default']),
            new LocationIsContainer(null, ['Default']),
            new LocationIsContainer(['message' => 'Not a container', 'groups' => $groups]),
            new LocationIsContainer(['groups' => self::GROUPS]),
            new LocationIsContainer(['message' => 'Not a container', 'groups' => null]),
            new ProductPriceCurrency($cart, ['message' => 'Wrong currency']),
            new ProductPriceCurrency($cart, null, 'Wrong currency'),
            new ProductPriceCurrency($cart, ['groups' => ['Default']], payload: 'x'),
            new ProductPriceCurrency($cart, ['message' => 'Wrong currency'], null, ['Default']),
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

    private const GROUPS = ['Default'];

    public function constraints(object $cart, array $groups): array
    {
        return [
            new LocationIsContainer(message: 'Not a container'),
            new LocationIsContainer(message: 'Not a container', groups: ['Default']),
            new LocationIsContainer(message: 'Not a container', groups: ['Default']),
            new LocationIsContainer(groups: ['Default'], payload: 'x'),
            new LocationIsContainer(groups: ['Default']),
            new LocationIsContainer(message: 'Not a container', groups: (array) $groups),
            new LocationIsContainer(groups: (array) self::GROUPS),
            new LocationIsContainer(message: 'Not a container'),
            new ProductPriceCurrency($cart, message: 'Wrong currency'),
            new ProductPriceCurrency($cart, 'Wrong currency'),
            new ProductPriceCurrency($cart, groups: ['Default'], payload: 'x'),
            new ProductPriceCurrency($cart, message: 'Wrong currency', groups: ['Default']),
        ];
    }
}

?>
