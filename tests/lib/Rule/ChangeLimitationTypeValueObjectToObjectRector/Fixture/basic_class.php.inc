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

?>
