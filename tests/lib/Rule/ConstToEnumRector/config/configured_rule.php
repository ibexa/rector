<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

use Ibexa\Rector\Rule\ConstToEnumValueRector;
use Rector\Config\RectorConfig;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->ruleWithConfiguration(
        ConstToEnumValueRector::class,
        [
            'Ibexa\Rector\Tests\Rule\ConstToEnumValueRector\Fixture\SomeClass' => [
                'enumClass' => 'Ibexa\Rector\Tests\Rule\ConstToEnumValueRector\Fixture\EnumClass',
                'constants' => [
                    'FOO' => 'FOO',
                    'BAR' => 'BAZ',
                ],
            ],
        ]
    );
};
