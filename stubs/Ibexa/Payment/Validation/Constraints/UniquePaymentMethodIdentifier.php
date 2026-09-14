<?php
declare(strict_types=1);

namespace Ibexa\Payment\Validation\Constraints;

use Symfony\Component\Validator\Constraint;

#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_METHOD)]
final class UniquePaymentMethodIdentifier extends Constraint
{
}
