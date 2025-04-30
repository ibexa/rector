<?php

declare(strict_types=1);

use Ibexa\Rector\Rule\AddReturnTypeFromParentMethodRule;
use Ibexa\Rector\Rule\Configuration\MethodReturnTypeConfiguration;
use Rector\Config\RectorConfig;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->ruleWithConfiguration(
        AddReturnTypeFromParentMethodRule::class,
        [
            new MethodReturnTypeConfiguration(
                'Ibexa\Rector\Tests\Rule\AddReturnTypeFromParentMethodRule\Fixture\SomeInterface',
                'someFunction'
            ),
        ]
    );
};
