<?php

use Ibexa\Contracts\Core\Repository\Values\ValueObject;
use Ibexa\Rector\Tests\Rule\ChangeLimitationTypeValueObjectToObjectRector\Source\BasicType;

final class FooBar extends BasicType
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
use Ibexa\Rector\Tests\Rule\ChangeLimitationTypeValueObjectToObjectRector\Source\BasicType;

final class FooBar extends BasicType
{
    public function evaluate(
        mixed $value,
        mixed $currentUser,
        object $object,
        array $targets = null
    ): ?bool {
        return null;
    }
}

?>
