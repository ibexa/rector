<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Contracts\Rector\Sets;

use Ibexa\Rector\Rule\PropertyToGetterRector;
use Ibexa\Rector\Rule\RemoveArgumentFromMethodCallRector;
use Ibexa\Rector\Rule\ReplaceInterfaceRector;
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
    // List of rector rules to upgrade Ibexa projects to Ibexa DXP 5.0
    $rectorConfig->ruleWithConfiguration(
        RenameClassRector::class,
        [
            'Ibexa\\Bundle\\Core\\ApiLoader\\RepositoryConfigurationProvider' => 'Ibexa\\Contracts\\Core\\Container\\ApiLoader\\RepositoryConfigurationProviderInterface',
        ]
    );

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

    $rectorConfig->ruleWithConfiguration(
        RenameClassConstFetchRector::class,
        [
            new RenameClassAndConstFetch(
                'Ibexa\Bundle\FormBuilder\DependencyInjection\Configuration',
                'TREE_ROOT',
                'Ibexa\Bundle\FormBuilder\DependencyInjection\IbexaFormBuilderExtension',
                'EXTENSION_NAME'
            ),
        ]
    );

    $rectorConfig->ruleWithConfiguration(
        RenameClassConstFetchRector::class,
        [
            new RenameClassAndConstFetch(
                'Ibexa\Migration\ValueObject\ContentType\Matcher',
                'CONTENT_TYPE_IDENTIFIER',
                'Ibexa\Migration\StepExecutor\ContentType\IdentifierFinder',
                'CONTENT_TYPE_IDENTIFIER'
            ),
        ]
    );

    $rectorConfig->ruleWithConfiguration(
        RenameClassRector::class,
        [
            'Ibexa\\Solr\\Gateway\\UpdateSerializer' => 'Ibexa\\Solr\\Gateway\\UpdateSerializer\\XmlUpdateSerializer',
        ]
    );

    $rectorConfig->ruleWithConfiguration(
        RenameClassRector::class,
        [
            'Ibexa\\Solr\\Query\\Content\\CriterionVisitor\\Field' => 'Ibexa\\Solr\\Query\\Common\\CriterionVisitor\\Field',
        ]
    );

    $rectorConfig->ruleWithConfiguration(
        RenamePropertyRector::class,
        [
            new RenameProperty(
                'Ibexa\Contracts\Core\Repository\Values\Content\Trash\SearchResult',
                'count',
                'totalCount',
            ),
        ]
    );

    $rectorConfig->ruleWithConfiguration(
        RenamePropertyRector::class,
        [
            new RenameProperty(
                'Ibexa\Contracts\Core\Repository\Values\Content\Search\SearchResult',
                'spellSuggestion',
                'spellcheck',
            ),
        ]
    );

    $rectorConfig->ruleWithConfiguration(
        ReplaceInterfaceRector::class,
        [
            'to_replace' => 'Ibexa\Bundle\Core\Imagine\VariationPathGenerator',
            'replace_with' => 'Ibexa\Contracts\Core\Variation\VariationPathGenerator',
        ]
    );

    $rectorConfig->ruleWithConfiguration(PropertyToGetterRector::class, [
        'Ibexa\Contracts\Core\Repository\Values\ContentType\ContentType' => [
            'isContainer' => 'isContainer',
        ],
    ]);

    $rectorConfig->ruleWithConfiguration(PropertyToGetterRector::class, [
        'Ibexa\Contracts\Core\Repository\Values\ContentType\ContentTypeDraft' => [
            'isContainer' => 'isContainer',
        ],
    ]);

    $rectorConfig->ruleWithConfiguration(PropertyToGetterRector::class, [
        'Ibexa\Core\Repository\Values\ContentType\ContentTypeDraft' => [
            'isContainer' => 'isContainer',
        ],
    ]);
};
