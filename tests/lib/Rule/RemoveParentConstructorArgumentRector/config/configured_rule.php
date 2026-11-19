<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

use Ibexa\Rector\Rule\Configuration\RemoveParentConstructorArgumentConfiguration;
use Ibexa\Rector\Rule\RemoveParentConstructorArgumentRector;
use Rector\Config\RectorConfig;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->ruleWithConfiguration(RemoveParentConstructorArgumentRector::class, [
        new RemoveParentConstructorArgumentConfiguration(
            'Ibexa\\Bundle\\RepositoryInstaller\\Installer\\CoreInstaller',
            1,
            'schemaBuilder'
        ),
        new RemoveParentConstructorArgumentConfiguration(
            'Ibexa\\Bundle\\RepositoryInstaller\\Installer\\CoreInstaller',
            2,
            'doctrineMigrationsEnabled'
        ),
    ]);
};
