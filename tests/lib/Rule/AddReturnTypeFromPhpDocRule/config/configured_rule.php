<?php

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
};
