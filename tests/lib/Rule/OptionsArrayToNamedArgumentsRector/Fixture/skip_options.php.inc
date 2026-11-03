<?php

namespace Ibexa\Rector\Tests\Rule\OptionsArrayToNamedArgumentsRector\Fixture;

use Ibexa\AdminUi\Validator\Constraints\LocationIsContainer;
use Ibexa\Contracts\Core\Validation\Constraint\UniqueIdentifier;
use Ibexa\Core\MVC\Symfony\Routing\SimplifiedRequest;

final class UniqueWithOwnConstructor extends UniqueIdentifier
{
    public function __construct(array $options)
    {
    }
}

final class UniqueInheritingIdentifier extends UniqueIdentifier
{
}

final class OtherConstraint
{
    public function __construct(array $options)
    {
    }
}

final class SkipOptions
{
    public function build(array $options, array $args): array
    {
        return [
            new LocationIsContainer(),
            new LocationIsContainer(message: 'Already named'),
            new LocationIsContainer($options),
            new LocationIsContainer(...$args),
            new LocationIsContainer(['unknownOption' => 'x']),
            new LocationIsContainer(['message' => 'a'], message: 'b'),
            new LocationIsContainer(['Default']),
            new UniqueInheritingIdentifier($options),
            new UniqueInheritingIdentifier('identifier', 'id'),
            new UniqueWithOwnConstructor(['identifierPath' => 'identifier']),
            new OtherConstraint(['message' => 'x']),
            new SimplifiedRequest('https', 'example.com'),
        ];
    }
}

?>
