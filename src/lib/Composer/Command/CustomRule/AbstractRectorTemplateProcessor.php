<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Rector\Composer\Command\CustomRule;

/**
 * @internal
 */
abstract class AbstractRectorTemplateProcessor
{
    protected function buildRectorName(string $ruleName): string
    {
        $rectorName = $ruleName;
        // suffix with Rector by convention
        if (!str_ends_with($rectorName, 'Rector')) {
            $rectorName .= 'Rector';
        }

        return ucfirst($rectorName);
    }
}
