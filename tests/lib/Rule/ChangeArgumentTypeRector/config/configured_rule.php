<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

use Ibexa\Rector\Rule\ChangeArgumentTypeRector;
use Ibexa\Rector\Rule\Configuration\ChangeArgumentTypeConfiguration;
use Rector\Config\RectorConfig;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->ruleWithConfiguration(ChangeArgumentTypeRector::class, [
        'configuration' => new ChangeArgumentTypeConfiguration(
            'Ibexa\\Contracts\\Core\\Limitation\\Type',
            'evaluate',
            2,
            'Ibexa\\Contracts\\Core\\Repository\\Values\\ValueObject',
        ),
    ]);
};
