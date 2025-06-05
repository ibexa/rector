<?php

use Ibexa\Contracts\Core\Repository\Values\ValueObject;
use Ibexa\Contracts\Core\Limitation\Type;

class Foo implements Type
{
    public function evaluate(
        mixed $value,
        mixed $currentUser,
        ValueObject $differentName,
        array $targets = null
    ): ?bool {
        return null;
    }
}

interface SubType extends Type
{
    public function evaluate(
        mixed $value,
        mixed $currentUser,
        ValueObject $object,
        array $targets = null,
        bool $foo = false
    ): ?bool;
}

abstract class Bar implements Type
{
    public function evaluate(
        mixed $value,
        mixed $currentUser,
        ValueObject $object,
        array $targets = null
    ): ?bool {
        return null;
    }
}

final class FooBar extends Foo
{
    public function evaluate(
        mixed $value,
        mixed $currentUser,
        ValueObject $object,
        array $targets = null
    ): ?bool {
        return null;
    }
}

class ShouldNotBeChanged {
    public function evaluate(
        mixed $value,
        mixed $currentUser,
        ValueObject $object,
        array $targets = null
    ): ?bool {}
}

?>
-----
<?php

use Ibexa\Contracts\Core\Repository\Values\ValueObject;
use Ibexa\Contracts\Core\Limitation\Type;

class Foo implements Type
{
    public function evaluate(
        mixed $value,
        mixed $currentUser,
        \object $differentName,
        array $targets = null
    ): ?bool {
        return null;
    }
}

interface SubType extends Type
{
    public function evaluate(
        mixed $value,
        mixed $currentUser,
        \object $object,
        array $targets = null,
        bool $foo = false
    ): ?bool;
}

abstract class Bar implements Type
{
    public function evaluate(
        mixed $value,
        mixed $currentUser,
        \object $object,
        array $targets = null
    ): ?bool {
        return null;
    }
}

final class FooBar extends Foo
{
    public function evaluate(
        mixed $value,
        mixed $currentUser,
        \object $object,
        array $targets = null
    ): ?bool {
        return null;
    }
}

class ShouldNotBeChanged {
    public function evaluate(
        mixed $value,
        mixed $currentUser,
        ValueObject $object,
        array $targets = null
    ): ?bool {}
}

?>
