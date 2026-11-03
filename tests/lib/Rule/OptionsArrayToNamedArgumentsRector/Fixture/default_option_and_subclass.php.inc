<?php

namespace Ibexa\Rector\Tests\Rule\OptionsArrayToNamedArgumentsRector\Fixture;

use Ibexa\Contracts\Core\Validation\Constraint\UniqueIdentifier;
use Ibexa\Core\MVC\Symfony\Routing\SimplifiedRequest;

final class UniqueProjectIdentifier extends UniqueIdentifier
{
}

final class DefaultOptionAndSubclass
{
    public function build(): array
    {
        return [
            new UniqueProjectIdentifier('identifier'),
            new UniqueProjectIdentifier(['identifierPath' => 'identifier', 'existingIdPath' => 'id']),
            new SimplifiedRequest(['scheme' => 'https', 'host' => 'example.com', 'pathinfo' => '/']),
        ];
    }
}

?>
-----
<?php

namespace Ibexa\Rector\Tests\Rule\OptionsArrayToNamedArgumentsRector\Fixture;

use Ibexa\Contracts\Core\Validation\Constraint\UniqueIdentifier;
use Ibexa\Core\MVC\Symfony\Routing\SimplifiedRequest;

final class UniqueProjectIdentifier extends UniqueIdentifier
{
}

final class DefaultOptionAndSubclass
{
    public function build(): array
    {
        return [
            new UniqueProjectIdentifier(identifierPath: 'identifier'),
            new UniqueProjectIdentifier(identifierPath: 'identifier', existingIdPath: 'id'),
            new SimplifiedRequest(scheme: 'https', host: 'example.com', pathinfo: '/'),
        ];
    }
}

?>
