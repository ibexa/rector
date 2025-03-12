<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Contracts\Rector\Sets;

use Rector\Config\RectorConfig;
use Rector\Renaming\Rector\ClassConstFetch\RenameClassConstFetchRector;
use Rector\Renaming\Rector\PropertyFetch\RenamePropertyRector;
use Rector\Renaming\ValueObject\RenameClassConstFetch;
use Rector\Renaming\ValueObject\RenameProperty;

return static function (RectorConfig $rectorConfig): void {
    // List of rector rules to upgrade Ibexa projects to Ibexa DXP 4.6

    $rectorConfig->ruleWithConfiguration(
        RenameClassConstFetchRector::class,
        [
            new RenameClassConstFetch(
                'Ibexa\Bundle\SystemInfo\SystemInfo\Collector\IbexaSystemInfoCollector',
                'CONTENT_PACKAGES',
                'HEADLESS_PACKAGES'
            ),
            new RenameClassConstFetch(
                'Ibexa\Bundle\SystemInfo\SystemInfo\Collector\IbexaSystemInfoCollector',
                'ENTERPRISE_PACKAGES',
                'HEADLESS_PACKAGES'
            ),
        ]
    );

    $rectorConfig->ruleWithConfiguration(
        RenamePropertyRector::class,
        [
            new RenameProperty(
                'Ibexa\Bundle\SystemInfo\SystemInfo\Value\IbexaSystemInfo',
                'stability',
                'lowestStability',
            ),
        ]
    );
};
