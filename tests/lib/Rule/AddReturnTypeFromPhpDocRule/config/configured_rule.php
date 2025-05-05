<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

use Ibexa\Rector\Rule\AddReturnTypeFromPhpDocRule;
use Ibexa\Rector\Rule\Configuration\MethodReturnTypeConfiguration;
use Rector\Config\RectorConfig;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->ruleWithConfiguration(
        AddReturnTypeFromPhpDocRule::class,
        [
            new MethodReturnTypeConfiguration(
                'Ibexa\Rector\Tests\Rule\AddReturnTypeFromPhpDocRule\Fixture\SomeInterface',
                'someFunction'
            ),
        ]
    );

    $rectorConfig->ruleWithConfiguration(
        AddReturnTypeFromPhpDocRule::class,
        [
            new MethodReturnTypeConfiguration(
                'Ibexa\Rector\Tests\Rule\AddReturnTypeFromPhpDocRule\Fixture\SomeAbstract',
                'someFunction'
            ),
        ]
    );
};
