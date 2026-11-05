<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

use Ibexa\Rector\Rule\Configuration\MethodCallToChainedMethodCallConfiguration;
use Ibexa\Rector\Rule\MethodCallToChainedMethodCallRector;
use Rector\Config\RectorConfig;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->ruleWithConfiguration(
        MethodCallToChainedMethodCallRector::class,
        [
            new MethodCallToChainedMethodCallConfiguration(
                'Ibexa\Contracts\ProductCatalog\Values\Price\Update\Struct\ProductPriceUpdateStructInterface',
                'getId',
                ['getPrice', 'getId'],
            ),
            new MethodCallToChainedMethodCallConfiguration(
                'Ibexa\Contracts\ProductCatalog\Values\Price\Delete\Struct\ProductPriceDeleteStructInterface',
                'getId',
                ['getPrice', 'getId'],
            ),
        ]
    );
};
