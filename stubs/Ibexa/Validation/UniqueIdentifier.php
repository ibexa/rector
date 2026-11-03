<?php

namespace Ibexa\Contracts\Core\Validation\Constraint;

use Symfony\Component\Validator\Constraint;

abstract class UniqueIdentifier extends Constraint
{
    public function __construct(
        string $identifierPath,
        ?string $existingIdPath = null,
        ?string $reportErrorPath = null,
        ?string $message = null,
        ?array $groups = null,
        mixed $payload = null
    ) {
    }
}
