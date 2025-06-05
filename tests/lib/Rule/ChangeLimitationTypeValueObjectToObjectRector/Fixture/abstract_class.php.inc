<?php

use Ibexa\Contracts\Core\Repository\Values\ValueObject;
use Ibexa\Contracts\Core\Limitation\Type;

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

?>
-----
<?php

use Ibexa\Contracts\Core\Repository\Values\ValueObject;
use Ibexa\Contracts\Core\Limitation\Type;

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

?>
