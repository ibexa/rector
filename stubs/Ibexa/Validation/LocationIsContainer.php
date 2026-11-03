<?php

namespace Ibexa\AdminUi\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

final class LocationIsContainer extends Constraint
{
    public function __construct(?string $message = null, ?array $groups = null, mixed $payload = null)
    {
    }
}
