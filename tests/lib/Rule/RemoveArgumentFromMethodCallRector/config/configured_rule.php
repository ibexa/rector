<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

use Ibexa\Rector\Rule\RemoveArgumentFromMethodCallRector;
use Rector\Config\RectorConfig;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->ruleWithConfiguration(
        RemoveArgumentFromMethodCallRector::class,
        [
            'class_name' => 'Ibexa\Rector\Tests\Rule\RemoveArgumentFromMethodCallRector\Fixture\SomeClass',
            'method_name' => 'foo',
            'argument_index_to_remove' => 1,
            'more_than' => 2,
        ]
    );
};
