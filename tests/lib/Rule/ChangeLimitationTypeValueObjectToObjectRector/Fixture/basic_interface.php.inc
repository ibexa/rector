<?php

use Ibexa\Contracts\Core\Repository\Values\ValueObject;
use Ibexa\Contracts\Core\Limitation\Type;

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

?>
-----
<?php

use Ibexa\Contracts\Core\Repository\Values\ValueObject;
use Ibexa\Contracts\Core\Limitation\Type;

interface SubType extends Type
{
    public function evaluate(
        mixed $value,
        mixed $currentUser,
        object $object,
        array $targets = null,
        bool $foo = false
    ): ?bool;
}

?>
