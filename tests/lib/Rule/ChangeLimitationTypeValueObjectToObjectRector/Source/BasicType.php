<?php

namespace Ibexa\Rector\Tests\Rule\ChangeLimitationTypeValueObjectToObjectRector\Source;

use Ibexa\Contracts\Core\Limitation\Type;

class BasicType implements Type
{
    public function evaluate(mixed $value, mixed $currentUser, object $differentName, ?array $targets = null): ?bool
    {
        return null;
    }
}
