<?php

namespace Ibexa\Rector\Tests\Sets\Ibexa60\Fixture;

use Ibexa\AdminUi\Validator\Constraints\LocationIsContainer;
use Ibexa\Cart\Validation\Constraint\ProductPriceCurrency;
use Ibexa\Core\MVC\Symfony\Routing\SimplifiedRequest;

final class OptionsArrayToNamedArguments
{
    public function build(object $cart): array
    {
        return [
            new LocationIsContainer(['message' => 'Not a container']),
            new ProductPriceCurrency($cart, ['message' => 'Wrong currency']),
            new SimplifiedRequest(['scheme' => 'https', 'host' => 'example.com']),
        ];
    }
}

?>
-----
<?php

namespace Ibexa\Rector\Tests\Sets\Ibexa60\Fixture;

use Ibexa\AdminUi\Validator\Constraints\LocationIsContainer;
use Ibexa\Cart\Validation\Constraint\ProductPriceCurrency;
use Ibexa\Core\MVC\Symfony\Routing\SimplifiedRequest;

final class OptionsArrayToNamedArguments
{
    public function build(object $cart): array
    {
        return [
            new LocationIsContainer(message: 'Not a container'),
            new ProductPriceCurrency($cart, message: 'Wrong currency'),
            new SimplifiedRequest(scheme: 'https', host: 'example.com'),
        ];
    }
}

?>
