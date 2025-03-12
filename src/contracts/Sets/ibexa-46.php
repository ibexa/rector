<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Contracts\Rector\Sets;

use Ibexa\Rector\Rule\PropertyToGetterRector;
use Ibexa\Rector\Rule\RemoveArgumentFromMethodCallRector;
use Rector\Config\RectorConfig;
use Rector\Renaming\Rector\ClassConstFetch\RenameClassConstFetchRector;
use Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use Rector\Renaming\Rector\Name\RenameClassRector;
use Rector\Renaming\Rector\PropertyFetch\RenamePropertyRector;
use Rector\Renaming\ValueObject\MethodCallRename;
use Rector\Renaming\ValueObject\RenameClassAndConstFetch;
use Rector\Renaming\ValueObject\RenameClassConstFetch;
use Rector\Renaming\ValueObject\RenameProperty;

return static function (RectorConfig $rectorConfig): void {
    // List of rector rules to upgrade Ibexa projects to Ibexa DXP 4.6

    $rectorConfig->ruleWithConfiguration(
        RenameClassConstFetchRector::class,
        [
            new RenameClassConstFetch(
                'Ibexa\Bundle\SystemInfo\SystemInfo\Collector\IbexaSystemInfoCollector',
                'CONTENT_PACKAGES',
                'HEADLESS_PACKAGES'
            ),
            new RenameClassConstFetch(
                'Ibexa\Bundle\SystemInfo\SystemInfo\Collector\IbexaSystemInfoCollector',
                'ENTERPRISE_PACKAGES',
                'HEADLESS_PACKAGES'
            ),
        ]
    );

    $rectorConfig->ruleWithConfiguration(
        RenamePropertyRector::class,
        [
            new RenameProperty(
                'Ibexa\Bundle\SystemInfo\SystemInfo\Value\IbexaSystemInfo',
                'stability',
                'lowestStability',
            ),
        ]
    );

    $rectorConfig->ruleWithConfiguration(
        RenameMethodRector::class,
        [
            new MethodCallRename(
                'Ibexa\Contracts\Rest\Output\Generator',
                'generateMediaType',
                'generateMediaTypeWithVendor'
            ),
            new MethodCallRename(
                'Ibexa\Rest\Output\FieldTypeSerializer',
                'serializeFieldValue',
                'serializeContentFieldValue'
            ),
        ]
    );

    $rectorConfig->ruleWithConfiguration(
        RemoveArgumentFromMethodCallRector::class,
        [
            'class_name' => 'Ibexa\Rest\Output\FieldTypeSerializer',
            'method_name' => 'serializeContentFieldValue',
            'argument_index_to_remove' => 1,
            'more_than' => 2,
        ]
    );

    $rectorConfig->ruleWithConfiguration(
        RenameClassConstFetchRector::class,
        [
            new RenameClassAndConstFetch(
                'Ibexa\Bundle\FieldTypePage\DependencyInjection\Compiler\BlockDefinitionConfigurationCompilerPass',
                'EXTENSION_CONFIG_KEY',
                'Ibexa\Bundle\FieldTypePage\DependencyInjection\IbexaFieldTypePageExtension',
                'EXTENSION_NAME'
            ),
            new RenameClassAndConstFetch(
                'Ibexa\Bundle\FieldTypePage\DependencyInjection\Compiler\AbstractConfigurationAwareCompilerPass',
                'EXTENSION_CONFIG_KEY',
                'Ibexa\Bundle\FieldTypePage\DependencyInjection\IbexaFieldTypePageExtension',
                'EXTENSION_NAME'
            ),
        ]
    );

    $rectorConfig->ruleWithConfiguration(
        PropertyToGetterRector::class,
        [
            'Ibexa\Core\MVC\Symfony\Routing\SimplifiedRequest' => [
                'scheme' => 'getScheme',
                'host' => 'getHost',
                'port' => 'getPort',
                'pathinfo' => 'getPathInfo',
                'queryParams' => 'getQueryParams',
                'languages' => 'getLanguages',
                'headers' => 'getHeaders',
            ],
        ]
    );

    $rectorConfig->ruleWithConfiguration(
        RenameClassRector::class,
        [
            'Ibexa\Cart\Money\MoneyFactory' => 'Ibexa\ProductCatalog\Money\IntlMoneyFactory',
        ]
    );

    $rectorConfig->ruleWithConfiguration(
        RenameClassConstFetchRector::class,
        [
            new RenameClassAndConstFetch(
                'Ibexa\Bundle\SiteFactory\DependencyInjection\Configuration',
                'TREE_ROOT',
                'Ibexa\Bundle\SiteFactory\DependencyInjection\IbexaSiteFactoryExtension',
                'EXTENSION_NAME'
            ),
        ]
    );

    $rectorConfig->ruleWithConfiguration(
        RenameClassRector::class,
        [
            'Ibexa\\Bundle\\Shipping\\Form\\Type\\RegionChoiceType' => 'Ibexa\\Bundle\\ProductCatalog\\Form\\Type\\RegionChoiceType',
            'Ibexa\\Contracts\\Shipping\\Iterator\\BatchIteratorAdapter\\RegionFetchAdapter' => 'Ibexa\\Contracts\\ProductCatalog\\Iterator\\BatchIteratorAdapter\\RegionFetchAdapter',
        ],
    );
};
