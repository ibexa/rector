<?php

namespace Ibexa\Contracts\Core\Limitation;

interface Type
{
    /**
     * @param array<mixed>|null $targets
     */
    public function evaluate(
        mixed $value,
        mixed $currentUser,
        object $differentName,
        ?array $targets = null
    ): ?bool;
}
