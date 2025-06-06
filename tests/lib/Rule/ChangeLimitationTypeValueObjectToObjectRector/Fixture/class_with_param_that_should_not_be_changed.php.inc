<?php

use Ibexa\Contracts\Core\Limitation\Type;
use Ibexa\Contracts\Core\Repository\Values\ValueObject;

class WithParamThatShouldNotBeChanged implements Type {
    public function evaluate(
        mixed $value,
        mixed $currentUser,
        object $object,
        array $targets = null
    ): ?bool {}
}

?>
