<?php

namespace Ibexa\FieldTypePage\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

class ContentType extends Constraint
{
    public function __construct(string|array $types, ?string $message = null, ?array $groups = null, mixed $payload = null)
    {
    }
}
