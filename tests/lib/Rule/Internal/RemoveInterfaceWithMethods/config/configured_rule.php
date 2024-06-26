<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

use Ibexa\Rector\Rule\Internal\RemoveInterfaceWithMethodsRector;
use Ibexa\Rector\Tests\Rule\Internal\RemoveInterfaceWithMethods\Fixture\SomeInterface;
use Rector\Config\RectorConfig;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->ruleWithConfiguration(
        RemoveInterfaceWithMethodsRector::class,
        [SomeInterface::class]
    );
};
