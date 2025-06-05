<?php

use Ibexa\Contracts\Core\Repository\Values\ValueObject;
use Ibexa\Rector\Tests\Rule\ChangeLimitationTypeValueObjectToObjectRector\Source\AbstractType;

class Foo extends AbstractType
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
use Ibexa\Rector\Tests\Rule\ChangeLimitationTypeValueObjectToObjectRector\Source\AbstractType;

class Foo extends AbstractType
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
