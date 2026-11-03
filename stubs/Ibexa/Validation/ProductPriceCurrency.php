<?php

namespace Ibexa\Cart\Validation\Constraint;

use Symfony\Component\Validator\Constraint;

final class ProductPriceCurrency extends Constraint
{
    public function __construct(object $cart, ?string $message = null, ?array $groups = null, mixed $payload = null)
    {
    }
}
