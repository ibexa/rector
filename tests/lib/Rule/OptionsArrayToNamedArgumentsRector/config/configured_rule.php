<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

use Ibexa\Rector\Rule\Configuration\OptionsArrayToNamedArgumentsConfiguration;
use Ibexa\Rector\Rule\OptionsArrayToNamedArgumentsRector;
use Rector\Config\RectorConfig;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->ruleWithConfiguration(
        OptionsArrayToNamedArgumentsRector::class,
        [
            // a configured class whose package the project doesn't install
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\NotInstalled\Constraint',
                ['message', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\AdminUi\Validator\Constraints\LocationIsContainer',
                ['message', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\Cart\Validation\Constraint\ProductPriceCurrency',
                ['cart', 'message', 'groups', 'payload'],
                ['cart', 'options', 'message', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\Contracts\Core\Validation\Constraint\UniqueIdentifier',
                ['identifierPath', 'existingIdPath', 'reportErrorPath', 'message', 'groups', 'payload'],
                defaultOption: 'identifierPath',
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\Core\MVC\Symfony\Routing\SimplifiedRequest',
                ['scheme', 'host', 'port', 'pathinfo', 'queryParams', 'languages', 'headers'],
                ['options'],
            ),
        ]
    );
};
