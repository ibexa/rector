<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

use Ibexa\Rector\Rule\AddParentConstructorArgumentRector;
use Ibexa\Rector\Rule\Configuration\AddParentConstructorArgumentConfiguration;
use Rector\Config\RectorConfig;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->ruleWithConfiguration(AddParentConstructorArgumentRector::class, [
        new AddParentConstructorArgumentConfiguration(
            'Ibexa\\Core\\Search\\Legacy\\Content\\Common\\Gateway\\CriterionHandler',
            1,
            'joinedTablesTracker',
            'Ibexa\\Core\\Persistence\\Doctrine\\JoinedTablesTracker'
        ),
        // listed out of order on purpose, position 3 counts the argument inserted at position 2
        new AddParentConstructorArgumentConfiguration(
            'Ibexa\\Bundle\\RepositoryInstaller\\Installer\\CoreInstaller',
            3,
            'dbPlatformFactory',
            'Ibexa\\Contracts\\DoctrineSchema\\DbPlatformFactoryInterface'
        ),
        new AddParentConstructorArgumentConfiguration(
            'Ibexa\\Bundle\\RepositoryInstaller\\Installer\\CoreInstaller',
            2,
            'logger',
            'Psr\\Log\\LoggerInterface'
        ),
    ]);
};
