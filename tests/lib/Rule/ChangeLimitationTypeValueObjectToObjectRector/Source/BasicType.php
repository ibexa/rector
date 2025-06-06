<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Rector\Tests\Rule\ChangeLimitationTypeValueObjectToObjectRector\Source;

use Ibexa\Contracts\Core\Limitation\Type;

class BasicType implements Type
{
    public function evaluate(mixed $value, mixed $currentUser, object $differentName, ?array $targets = null): ?bool
    {
        return null;
    }
}
