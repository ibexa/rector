<?php

use Ibexa\Contracts\Core\Repository\Values\ValueObject;

class ShouldNotBeChanged {
    public function evaluate(
        mixed $value,
        mixed $currentUser,
        ValueObject $object,
        array $targets = null
    ): ?bool {}
}

?>
