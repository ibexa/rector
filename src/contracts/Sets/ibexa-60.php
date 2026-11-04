<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Contracts\Rector\Sets;

use Ibexa\Rector\Rule\AddParentConstructorArgumentRector;
use Ibexa\Rector\Rule\AddReturnTypeFromParentMethodRule;
use Ibexa\Rector\Rule\AddReturnTypeFromPhpDocRule;
use Ibexa\Rector\Rule\ChangeArgumentTypeRector;
use Ibexa\Rector\Rule\Configuration\AddParentConstructorArgumentConfiguration;
use Ibexa\Rector\Rule\Configuration\ChangeArgumentTypeConfiguration;
use Ibexa\Rector\Rule\Configuration\MethodCallToChainedMethodCallConfiguration;
use Ibexa\Rector\Rule\Configuration\MethodReturnTypeConfiguration;
use Ibexa\Rector\Rule\Configuration\OptionsArrayToNamedArgumentsConfiguration;
use Ibexa\Rector\Rule\ConstToEnumValueRector;
use Ibexa\Rector\Rule\MethodCallToChainedMethodCallRector;
use Ibexa\Rector\Rule\OptionsArrayToNamedArgumentsRector;
use Ibexa\Rector\Rule\PlatformGetNameToDatabasePlatformResolverRector;
use Ibexa\Rector\Rule\PropertyToGetterRector;
use Ibexa\Rector\Rule\RemoveArgumentFromMethodCallRector;
use Ibexa\Rector\Rule\RestVisitorSetHeaderRector;
use PHPStan\Type\ArrayType;
use PHPStan\Type\MixedType;
use PHPStan\Type\ObjectType;
use Rector\Config\RectorConfig;
use Rector\Doctrine\Set\DoctrineSetList;
use Rector\Removing\Rector\Class_\RemoveInterfacesRector;
use Rector\Renaming\Rector\ClassConstFetch\RenameClassConstFetchRector;
use Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use Rector\Renaming\Rector\Name\RenameClassRector;
use Rector\Renaming\Rector\PropertyFetch\RenamePropertyRector;
use Rector\Renaming\ValueObject\MethodCallRename;
use Rector\Renaming\ValueObject\RenameClassAndConstFetch;
use Rector\Renaming\ValueObject\RenameClassConstFetch;
use Rector\Renaming\ValueObject\RenameProperty;
use Rector\Symfony\Symfony62\Rector\MethodCall\SimplifyFormRenderingRector;
use Rector\TypeDeclaration\Rector\ClassMethod\AddReturnTypeDeclarationRector;
use Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration;

return static function (RectorConfig $rectorConfig): void {
    // List of rector rules to upgrade Ibexa projects to Ibexa DXP 6.0
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
                'Ibexa\Contracts\Core\Repository\Values\ObjectState\ObjectStateGroup',
                'defaultLanguageCode',
                'mainLanguageCode',
            ),
            new RenameProperty(
                'Ibexa\Contracts\Core\Repository\Values\ObjectState\ObjectState',
                'defaultLanguageCode',
                'mainLanguageCode',
            ),
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
        RenameClassRector::class,
        [
            'Ibexa\Bundle\Core\Imagine\VariationPathGenerator' => 'Ibexa\Contracts\Core\Variation\VariationPathGenerator',
        ]
    );

    $rectorConfig->ruleWithConfiguration(
        RenameClassRector::class,
        [
            'Ibexa\Bundle\Messenger\Stamp\DeduplicateStamp' => 'Symfony\Component\Messenger\Stamp\DeduplicateStamp',
            'Ibexa\Contracts\Messenger\Stamp\DeduplicateStamp' => 'Symfony\Component\Messenger\Stamp\DeduplicateStamp',
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

    $rectorConfig->ruleWithConfiguration(
        ConstToEnumValueRector::class,
        [
            'Ibexa\Contracts\Core\Repository\Values\Content\Relation' => [
                'enumClass' => 'Ibexa\Contracts\Core\Repository\Values\Content\RelationType',
                'constants' => [
                    'COMMON' => 'COMMON',
                    'EMBED' => 'EMBED',
                    'LINK' => 'LINK',
                    'FIELD' => 'FIELD',
                    'ASSET' => 'ASSET',
                ],
            ],
        ]
    );

    $rectorConfig->ruleWithConfiguration(
        AddReturnTypeFromPhpDocRule::class,
        [
            new MethodReturnTypeConfiguration(
                'Ibexa\Contracts\Rest\Input\Parser',
                'parse'
            ),
        ]
    );

    $rectorConfig->ruleWithConfiguration(
        AddReturnTypeFromParentMethodRule::class,
        [
            new MethodReturnTypeConfiguration(
                'Ibexa\Contracts\Rest\Input\Parser',
                'parse'
            ),
        ]
    );

    $rectorConfig->ruleWithConfiguration(
        AddReturnTypeDeclarationRector::class,
        [
            new AddReturnTypeDeclaration(
                'Ibexa\Bundle\Core\Imagine\Filter\UnsupportedFilter',
                'apply',
                new ObjectType('Imagine\Image\ImageInterface')
            ),
            new AddReturnTypeDeclaration(
                'Ibexa\Core\MVC\Symfony\Templating\Twig\Extension\FieldRenderingExtension',
                'getFunctions',
                new ArrayType(new MixedType(), new MixedType())
            ),
        ]
    );

    $rectorConfig->ruleWithConfiguration(
        ChangeArgumentTypeRector::class,
        [
            new ChangeArgumentTypeConfiguration(
                'Ibexa\\Migration\\Generator\\StepBuilder\\StepFactoryInterface',
                'create',
                0,
                'Ibexa\\Contracts\\Core\\Repository\\Values\\ValueObject',
            ),
            new ChangeArgumentTypeConfiguration(
                'Ibexa\\Migration\\Generator\\StepBuilder\\AbstractStepFactory',
                'prepareLogMessage',
                0,
                'Ibexa\\Contracts\\Core\\Repository\\Values\\ValueObject',
            ),
            new ChangeArgumentTypeConfiguration(
                'Ibexa\\Migration\\StepExecutor\\ReferenceDefinition\\ResolverInterface',
                'resolve',
                1,
                'Ibexa\\Contracts\\Core\\Repository\\Values\\ValueObject'
            ),
            new ChangeArgumentTypeConfiguration(
                'Ibexa\\Migration\\Generator\\StepBuilder\\StepBuilderInterface',
                'build',
                0,
                'Ibexa\\Contracts\\Core\\Repository\\Values\\ValueObject'
            ),

            new ChangeArgumentTypeConfiguration(
                'Ibexa\\Contracts\\Core\\Limitation\\Type',
                'evaluate',
                2,
                'Ibexa\\Contracts\\Core\\Repository\\Values\\ValueObject'
            ),
        ]
    );

    // Doctrine upgrade rules (DBAL 3.8, 4.0, 4.2, ORM, ...), each applied only when the project has the matching version installed
    $rectorConfig->sets([DoctrineSetList::COMPOSER_BASED]);

    // Doctrine DBAL 4 binding types are enums instead of integers
    $rectorConfig->ruleWithConfiguration(
        AddReturnTypeDeclarationRector::class,
        [
            new AddReturnTypeDeclaration(
                'Ibexa\Contracts\CorePersistence\Gateway\DoctrineSchemaMetadataInterface',
                'getBindingTypeForColumn',
                new ObjectType('Doctrine\DBAL\ParameterType')
            ),
            new AddReturnTypeDeclaration(
                'Ibexa\ProductCatalog\Local\Repository\Search\Legacy\Criterion\SingleFieldAttributeVisitor',
                'getCriterionBindType',
                new ObjectType('Doctrine\DBAL\ParameterType')
            ),
        ]
    );

    $rectorConfig->ruleWithConfiguration(
        AddParentConstructorArgumentRector::class,
        [
            new AddParentConstructorArgumentConfiguration(
                'Ibexa\Core\Search\Legacy\Content\Common\Gateway\CriterionHandler',
                1,
                'joinedTablesTracker',
                'Ibexa\Core\Persistence\Doctrine\JoinedTablesTracker'
            ),
            new AddParentConstructorArgumentConfiguration(
                'Ibexa\Core\Search\Legacy\Content\Common\Gateway\CriterionHandler\FieldBase',
                3,
                'joinedTablesTracker',
                'Ibexa\Core\Persistence\Doctrine\JoinedTablesTracker'
            ),
            new AddParentConstructorArgumentConfiguration(
                'Ibexa\Core\Search\Legacy\Content\Common\Gateway\CriterionHandler\Field',
                6,
                'joinedTablesTracker',
                'Ibexa\Core\Persistence\Doctrine\JoinedTablesTracker'
            ),
            new AddParentConstructorArgumentConfiguration(
                'Ibexa\Core\Search\Legacy\Content\Common\Gateway\CriterionHandler\FieldEmpty',
                5,
                'joinedTablesTracker',
                'Ibexa\Core\Persistence\Doctrine\JoinedTablesTracker'
            ),
            new AddParentConstructorArgumentConfiguration(
                'Ibexa\Core\Search\Legacy\Content\Common\Gateway\CriterionHandler\FullText',
                3,
                'joinedTablesTracker',
                'Ibexa\Core\Persistence\Doctrine\JoinedTablesTracker'
            ),
            new AddParentConstructorArgumentConfiguration(
                'Ibexa\Measurement\ProductCatalog\Form\Attribute\Search\Criterion\AbstractMeasurementAttributeVisitor',
                2,
                'joinedTablesTracker',
                'Ibexa\Core\Persistence\Doctrine\JoinedTablesTracker'
            ),
            new AddParentConstructorArgumentConfiguration(
                'Ibexa\Bundle\RepositoryInstaller\Installer\CoreInstaller',
                2,
                'schemaAssetsFilterBypass',
                'Ibexa\Contracts\DoctrineSchema\SchemaAssetsFilterBypassInterface'
            ),
            new AddParentConstructorArgumentConfiguration(
                'Ibexa\Bundle\RepositoryInstaller\Installer\CoreInstaller',
                3,
                'dbPlatformFactory',
                'Ibexa\Contracts\DoctrineSchema\DbPlatformFactoryInterface'
            ),
            new AddParentConstructorArgumentConfiguration(
                'Ibexa\Installer\Installer\AbstractProductInstaller',
                2,
                'schemaAssetsFilterBypass',
                'Ibexa\Contracts\DoctrineSchema\SchemaAssetsFilterBypassInterface'
            ),
            new AddParentConstructorArgumentConfiguration(
                'Ibexa\Installer\Installer\AbstractProductInstaller',
                3,
                'dbPlatformFactory',
                'Ibexa\Contracts\DoctrineSchema\DbPlatformFactoryInterface'
            ),
        ]
    );

    // Doctrine DBAL 4 removed AbstractPlatform::getName()
    $rectorConfig->rule(PlatformGetNameToDatabasePlatformResolverRector::class);

    // ProductPrice{Update,Delete}Struct::getId() removed, the id is read from the price
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

    // Visitor::setHeader() takes a string value only, false means suppressHeader()
    $rectorConfig->rule(RestVisitorSetHeaderRector::class);

    // Ibexa constraints (and SimplifiedRequest) take named arguments instead of an options array
    $rectorConfig->ruleWithConfiguration(
        OptionsArrayToNamedArgumentsRector::class,
        [
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\AdminUi\Validator\Constraints\DateRangeConstraint',
                ['message', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\AdminUi\Validator\Constraints\FieldDefinitionDefaultValue',
                ['message', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\AdminUi\Validator\Constraints\FieldSettings',
                ['message', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\AdminUi\Validator\Constraints\LocationHasChildren',
                ['message', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\AdminUi\Validator\Constraints\LocationHaveUniqueAssetRelation',
                ['message', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\AdminUi\Validator\Constraints\LocationIsContainer',
                ['message', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\AdminUi\Validator\Constraints\LocationIsNotRoot',
                ['message', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\AdminUi\Validator\Constraints\LocationIsWithinCopySubtreeLimit',
                ['message', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\AdminUi\Validator\Constraints\UniqueContentTypeIdentifier',
                ['message', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\AdminUi\Validator\Constraints\UniqueFieldDefinitionIdentifier',
                ['message', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\AdminUi\Validator\Constraints\UniqueSectionIdentifier',
                ['message', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\AdminUi\Validator\Constraints\UniqueURL',
                ['message', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\AdminUi\Validator\Constraints\ValidatorConfiguration',
                ['message', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\Bundle\ProductCatalog\Validator\Constraints\AtLeastOneLanguageWillRemain',
                ['message', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\Bundle\ProductCatalog\Validator\Constraints\AttributeDefinitionOptions',
                ['type', 'message', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\Bundle\ProductCatalog\Validator\Constraints\AttributeValue',
                ['definition', 'product', 'message', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\Bundle\ProductCatalog\Validator\Constraints\UniqueAttributeDefinitionIdentifier',
                ['message', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\Bundle\ProductCatalog\Validator\Constraints\UniqueAttributeGroupIdentifier',
                ['message', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\Bundle\ProductCatalog\Validator\Constraints\UniqueCatalogIdentifier',
                ['message', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\Bundle\ProductCatalog\Validator\Constraints\UniqueCurrencyCode',
                ['message', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\Bundle\ProductCatalog\Validator\Constraints\UniqueCustomerGroupIdentifier',
                ['message', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\Bundle\ProductCatalog\Validator\Constraints\UniqueProductCode',
                ['message', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\Bundle\ProductCatalog\Validator\Constraints\UniqueProductPrice',
                ['message', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\Bundle\ProductCatalog\Validator\Constraints\UniqueProductPriceCustomerGroup',
                ['message', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\Bundle\ProductCatalog\Validator\Constraints\UniqueProductVariantAttributeCombination',
                ['message', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\Bundle\ShoppingList\Validator\Constraints\DefaultListName',
                ['defaultWithNameMessage', 'nonDefaultWithoutNameMessage', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\Bundle\ShoppingList\Validator\Constraints\NotAnonymousUser',
                ['message', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\Bundle\ShoppingList\Validator\Constraints\ProductCode',
                ['maxLength', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\Bundle\ShoppingList\Validator\Constraints\ProductExists',
                ['message', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\Bundle\ShoppingList\Validator\Constraints\ProductNotAlreadyInList',
                ['message', 'existingProductCodes', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\Bundle\ShoppingList\Validator\Constraints\ShoppingListName',
                ['maxLength', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\Bundle\ShoppingList\Validator\Constraints\UniqueProductCodesInBatch',
                ['message', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\Bundle\TranslationsManagement\AutoTranslate\Form\Validation\Constraint\DifferentSourceAndTargetLanguages',
                ['message', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\Bundle\TranslationsManagement\AutoTranslate\Form\Validation\Constraint\ProviderSupportsSelectedLanguages',
                ['message', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\Bundle\TranslationsManagement\AutoTranslate\Form\Validation\Constraint\UniqueLanguagePair',
                ['message', 'messageForDisabledProvider', 'messageForNotConfiguredProvider', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\Bundle\TranslationsManagement\AutoTranslate\Form\Validation\Constraint\ValidDefaultProviderSelection',
                ['providerNotConfiguredMessage', 'providerDisabledMessage', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\Cart\Validation\Constraint\BaseProduct',
                ['message', 'groups', 'payload'],
                ['options', 'message', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\Cart\Validation\Constraint\CartProductVatCategory',
                ['message', 'groups', 'payload'],
                ['options', 'message', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\Cart\Validation\Constraint\Compound\ProductCanBeAddedToCart',
                ['cart', 'groups', 'payload'],
                ['cart', 'options'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\Cart\Validation\Constraint\EntriesAddedAfterProductModificationDate',
                ['message', 'groups', 'payload'],
                ['options', 'message', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\Cart\Validation\Constraint\NoBaseProducts',
                ['message', 'groups', 'payload'],
                ['options', 'message', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\Cart\Validation\Constraint\ProductAvailable',
                ['message', 'groups', 'payload'],
                ['options', 'message', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\Cart\Validation\Constraint\ProductAvailableForQuantityChange',
                ['product', 'message', 'groups', 'payload'],
                ['product', 'options', 'message', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\Cart\Validation\Constraint\ProductAvailableForQuantityIncrease',
                ['cart', 'message', 'groups', 'payload'],
                ['cart', 'options', 'message', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\Cart\Validation\Constraint\ProductPriceCurrency',
                ['cart', 'message', 'groups', 'payload'],
                ['cart', 'options', 'message', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\Cart\Validation\Constraint\ProductVatCategory',
                ['message', 'groups', 'payload'],
                ['options', 'message', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\Cart\Validation\Constraint\ProductWithCodeExists',
                ['message', 'groups', 'payload'],
                ['options', 'message', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\Cart\Validation\Constraint\ProductsAvailableInCartCurrency',
                ['message', 'groups', 'payload'],
                ['options', 'message', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\Cart\Validation\Constraint\ProductsAvailableInQuantity',
                ['message', 'groups', 'payload'],
                ['options', 'message', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\Cart\Validation\Constraint\ProductsExist',
                ['message', 'groups', 'payload'],
                ['options', 'message', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\Cart\Validation\Constraint\QuickOrderIncompleteEntry',
                ['message', 'groups', 'payload'],
                ['options', 'message', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\ConnectorAi\Validation\Constraints\ActionConfigurationHandlerOptions',
                ['optionsPath', 'actionHandlerPath', 'message', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\ConnectorAi\Validation\Constraints\ActionConfigurationTypeOptions',
                ['optionsPath', 'actionTypePath', 'message', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\ConnectorAi\Validation\Constraints\UniqueActionConfigurationIdentifier',
                ['identifierPath', 'existingIdPath', 'reportErrorPath', 'message', 'groups', 'payload'],
                defaultOption: 'identifierPath',
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\ContentForms\Validator\Constraints\Password',
                ['contentType', 'message', 'groups', 'payload'],
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
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\Core\Repository\Validator\Constraint\LocationIsContainerContentType',
                ['message', 'groups', 'payload'],
                ['options', 'message', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\CorporateAccount\REST\Validation\Constraint\FieldDefinitionIdentifier',
                ['contentType', 'groups', 'payload'],
                ['contentType', 'options', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\CorporateAccount\REST\Validation\Constraint\FieldValuesListInput',
                ['contentType', 'groups', 'payload'],
                ['contentType', 'options', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\CorporateAccount\REST\Validation\Constraint\MediaType',
                ['expectedResourceName', 'message', 'groups', 'payload'],
                ['expectedResourceName', 'options', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\CorporateAccount\REST\Validation\Constraint\Resource',
                ['uriParser', 'message', 'groups', 'payload'],
                ['uriParser', 'options', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\CorporateAccount\Validation\Constraints\IsCorporateSiteAccess',
                ['message', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\CorporateAccount\Validation\Constraints\UniqueApplicationEmail',
                ['message', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\CorporateAccount\Validation\Constraints\ValidApplicationId',
                ['message', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\DiscountsCodes\Validation\Constraint\UniqueCode',
                ['codePath', 'reportErrorPath', 'message', 'groups', 'payload'],
                defaultOption: 'codePath',
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\Discounts\Validation\Constraint\AtLeastOneDiscountTranslationWillRemain',
                ['message', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\Discounts\Validation\Constraint\CountCategories',
                ['min', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\Discounts\Validation\Constraint\CountCustomerGroup',
                ['min', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\Discounts\Validation\Constraint\CountProducts',
                ['min', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\Discounts\Validation\Constraint\CurrencyRequired',
                ['groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\Discounts\Validation\Constraint\Identifier',
                ['groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\Discounts\Validation\Constraint\ValidDiscountRuleType',
                ['discountTypePropertyPath', 'message', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\Discounts\Validation\Constraint\ValidStep',
                ['groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\FieldTypeAddress\Validator\Constraints\RequiredAddressFields',
                ['addressType', 'isFieldDefinitionRequired', 'country', 'message', 'groups', 'payload'],
                ['addressType', 'isFieldDefinitionRequired', 'country', 'options', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\FieldTypePage\Validator\Constraints\ContentContainerType',
                ['message', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\FieldTypePage\Validator\Constraints\ContentType',
                ['types', 'message', 'groups', 'payload'],
                defaultOption: 'types',
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\FieldTypeRichText\Validator\Constraints\RichText',
                ['message', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\OrderManagement\Validation\Constraints\CompanyExisting',
                ['message', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\OrderManagement\Validation\Constraints\CurrencyExisting',
                ['message', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\OrderManagement\Validation\Constraints\CustomerExisting',
                ['message', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\OrderManagement\Validation\Constraints\MoneyAmountEqualToOrGreaterThanZero',
                ['message', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\OrderManagement\Validation\Constraints\ProductExisting',
                ['message', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\Payment\Validation\Constraints\AllowedPaymentStatusTransition',
                ['payment', 'message', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\Payment\Validation\Constraints\AtLeastOneTranslation',
                ['updateStruct', 'message', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\Payment\Validation\Constraints\EnabledPaymentMethod',
                ['message', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\Payment\Validation\Constraints\MoneyAmountEqualToOrGreaterThanZero',
                ['message', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\Payment\Validation\Constraints\PaymentMethodEnabled',
                ['message', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\Payment\Validation\Constraints\PaymentMethodOptions',
                ['type', 'message', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\Payment\Validation\Constraints\PaymentMethodUsed',
                ['message', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\Payment\Validation\Constraints\UniquePaymentIdentifier',
                ['originalPayment', 'message', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\Payment\Validation\Constraints\UniquePaymentMethodIdentifier',
                ['originalPaymentMethod', 'message', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\Personalization\Validator\Constraints\CategoryPath',
                ['message', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\Personalization\Validator\Constraints\FulfilledScenarioStrategyLevel',
                ['message', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\Personalization\Validator\Constraints\OutputType',
                ['message', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\Personalization\Validator\Constraints\SupportedModelDataType',
                ['modelList', 'referenceCode', 'message', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\Personalization\Validator\Constraints\UniqueScenarioName',
                ['customerId', 'actionType', 'referenceCode', 'message', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\Personalization\Validator\Constraints\UniqueScenarioReferenceCode',
                ['customerId', 'message', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\Segmentation\Validation\Constraint\UserToSegmentAssignment',
                ['message', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\Shipping\Validation\Constraints\AllowedShipmentStatusTransition',
                ['shipment', 'message', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\Shipping\Validation\Constraints\EnabledShippingMethod',
                ['message', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\Shipping\Validation\Constraints\MoneyAmountGreaterThanOrEqualZero',
                ['message', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\Shipping\Validation\Constraints\REST\MediaType',
                ['expectedResourceName', 'message', 'groups', 'payload'],
                ['expectedResourceName', 'options', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\Shipping\Validation\Constraints\ShippingMethodEnabled',
                ['message', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\Shipping\Validation\Constraints\ShippingMethodOptions',
                ['type', 'message', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\Shipping\Validation\Constraints\ShippingMethodUsed',
                ['message', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\Shipping\Validation\Constraints\ShippingMethodVoter',
                ['cart', 'message', 'groups', 'payload'],
                ['cart', 'options', 'message', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\Shipping\Validation\Constraints\UniqueShipmentIdentifier',
                ['originalShipment', 'message', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\Shipping\Validation\Constraints\UniqueShippingMethodIdentifier',
                ['originalShippingMethod', 'message', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\Taxonomy\Form\Type\Validation\Constraint\Nested',
                ['accessor', 'constraints', 'groups', 'payload'],
                ['accessor', 'constraints', 'options', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\Taxonomy\Form\Type\Validation\Constraint\UniqueIdentifier',
                ['taxonomy', 'message', 'groups', 'payload'],
                ['options', 'message', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\Taxonomy\Validator\Constraint\FieldDefinitionSettingsAreUnique',
                ['contentTypeDraft', 'message', 'groups', 'payload'],
                ['contentTypeDraft', 'options', 'message', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\User\Validator\Constraints\EmailInvitation',
                ['message', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\User\Validator\Constraints\Password',
                ['contentType', 'user', 'message', 'groups', 'payload'],
            ),
            new OptionsArrayToNamedArgumentsConfiguration(
                'Ibexa\User\Validator\Constraints\UserPassword',
                ['message', 'groups', 'payload'],
            ),
        ]
    );

    $rectorConfig->ruleWithConfiguration(
        RemoveInterfacesRector::class,
        [
            'Ibexa\Bundle\Core\Command\BackwardCompatibleCommand',
        ]
    );

    // classes removed in 6.0, replaced by the ones their 5.0 deprecation pointed at
    $rectorConfig->ruleWithConfiguration(
        RenameClassRector::class,
        [
            'Ibexa\\AdminUi\\Component\\Registry' => 'Ibexa\\TwigComponents\\Component\\Registry',
            'Ibexa\\AdminUi\\Component\\TwigComponent' => 'Ibexa\\TwigComponents\\Component\\TemplateComponent',
            'Ibexa\\AdminUi\\Component\\LinkComponent' => 'Ibexa\\TwigComponents\\Component\\LinkComponent',
            'Ibexa\\AdminUi\\Component\\ScriptComponent' => 'Ibexa\\TwigComponents\\Component\\ScriptComponent',
            'Ibexa\\Contracts\\AdminUi\\Component\\Renderable' => 'Ibexa\\Contracts\\TwigComponents\\ComponentInterface',
            'Ibexa\\Contracts\\AdminUi\\Component\\Renderer\\RendererInterface' => 'Ibexa\\Contracts\\TwigComponents\\Renderer\\RendererInterface',
            'Ibexa\\AdminUi\\Component\\Renderer\\DefaultRenderer' => 'Ibexa\\TwigComponents\\Component\\Renderer\\DefaultRenderer',
            'Ibexa\\AdminUi\\Component\\Event\\RenderGroupEvent' => 'Ibexa\\Contracts\\TwigComponents\\Event\\RenderGroupEvent',
            'Ibexa\\AdminUi\\Component\\Event\\RenderSingleEvent' => 'Ibexa\\Contracts\\TwigComponents\\Event\\RenderSingleEvent',
            'Ibexa\\Bundle\\AdminUi\\DependencyInjection\\Compiler\\ComponentPass' => 'Ibexa\\Bundle\\TwigComponents\\DependencyInjection\\Compiler\\ComponentPass',
            'Ibexa\\AdminUi\\Form\\Type\\Preview\\SiteAccessChoiceType' => 'Ibexa\\AdminUi\\Form\\Type\\Preview\\VersionPreviewUrlChoiceType',
            'Ibexa\\AdminUi\\Form\\Type\\ChoiceList\\Loader\\SiteAccessPreviewChoiceLoader' => 'Ibexa\\AdminUi\\Form\\Type\\ChoiceList\\Loader\\VersionPreviewUrlChoiceLoader',
            'Ibexa\\ContentForms\\Content\\Form\\Provider\\GroupedContentFormFieldsProvider' => 'Ibexa\\ContentForms\\Content\\Form\\Provider\\IdentifiedGroupedContentFormFieldsProvider',
            'Ibexa\\Contracts\\ProductCatalog\\Values\\Common\\Query\\AbstractCriterionQuery' => 'Ibexa\\Contracts\\CoreSearch\\Values\\Query\\AbstractCriterionQuery',
            'Ibexa\\Contracts\\ProductCatalog\\Values\\Common\\Query\\AbstractSortClause' => 'Ibexa\\Contracts\\CoreSearch\\Values\\Query\\AbstractSortClause',
            'Ibexa\\Contracts\\ProductCatalog\\Values\\Common\\Query\\SortDirection' => 'Ibexa\\Contracts\\CoreSearch\\Values\\Query\\SortDirection',
            'Ibexa\\Contracts\\ProductCatalog\\Values\\Common\\Query\\CriterionMapperInterface' => 'Ibexa\\Contracts\\CoreSearch\\Values\\Query\\CriterionMapperInterface',
            'Ibexa\\Contracts\\ProductCatalog\\Values\\Common\\Query\\Criterion\\AbstractCompositeCriterion' => 'Ibexa\\Contracts\\CoreSearch\\Values\\Query\\Criterion\\AbstractCompositeCriterion',
            'Ibexa\\Contracts\\ProductCatalog\\Values\\Common\\Query\\Criterion\\CriterionInterface' => 'Ibexa\\Contracts\\CoreSearch\\Values\\Query\\Criterion\\CriterionInterface',
            'Ibexa\\Contracts\\ProductCatalog\\Values\\Common\\Query\\SortClause\\FieldValueSortClause' => 'Ibexa\\Contracts\\CoreSearch\\Values\\Query\\SortClause\\FieldValueSortClause',
            'Ibexa\\ProductCatalog\\Common\\Pool' => 'Ibexa\\Contracts\\Core\\Pool\\Pool',
            'Ibexa\\Bundle\\ProductCatalog\\Form\\Type\\LanguageSwitchType' => 'Ibexa\\AdminUi\\Form\\Type\\LanguageSwitchType',
            'Ibexa\\Bundle\\ProductCatalog\\Form\\Type\\ReferenceCollectionType' => 'Ibexa\\AdminUi\\Form\\Type\\ReferenceCollectionType',
            'Ibexa\\Bundle\\ProductCatalog\\Form\\Data\\AbstractLanguageSwitchData' => 'Ibexa\\AdminUi\\Form\\Data\\AbstractLanguageSwitchData',
            'Ibexa\\Bundle\\Payment\\Form\\Data\\DateRangeData' => 'Ibexa\\AdminUi\\Form\\Data\\DateRangeData',
            'Ibexa\\Bundle\\Payment\\Form\\Type\\DateRangeType' => 'Ibexa\\AdminUi\\Form\\Type\\DateRangeType',
            'Ibexa\\Bundle\\Shipping\\Form\\Data\\DateRangeData' => 'Ibexa\\AdminUi\\Form\\Data\\DateRangeData',
            'Ibexa\\Bundle\\Shipping\\Form\\Type\\DateRangeType' => 'Ibexa\\AdminUi\\Form\\Type\\DateRangeType',
            'Ibexa\\Bundle\\Messenger\\Lock\\Store\\DoctrineDbalStore' => 'Symfony\\Component\\Lock\\Store\\DoctrineDbalStore',
            'Ibexa\\Segmentation\\Value\\Segment' => 'Ibexa\\Contracts\\Segmentation\\Value\\Segment',
            'Ibexa\\Segmentation\\Value\\SegmentGroup' => 'Ibexa\\Contracts\\Segmentation\\Value\\SegmentGroup',
            'Ibexa\\Segmentation\\Value\\SegmentCreateStruct' => 'Ibexa\\Contracts\\Segmentation\\Value\\SegmentCreateStruct',
            'Ibexa\\Segmentation\\Value\\SegmentUpdateStruct' => 'Ibexa\\Contracts\\Segmentation\\Value\\SegmentUpdateStruct',
            'Ibexa\\Segmentation\\Value\\SegmentGroupCreateStruct' => 'Ibexa\\Contracts\\Segmentation\\Value\\SegmentGroupCreateStruct',
            'Ibexa\\Segmentation\\Value\\SegmentGroupUpdateStruct' => 'Ibexa\\Contracts\\Segmentation\\Value\\SegmentGroupUpdateStruct',
            'Ibexa\\Bundle\\ProductCatalog\\Menu\\AbstractFormContextMenuBuilder' => 'Ibexa\\Contracts\\AdminUi\\Menu\\AbstractFormContextMenuBuilder',
            'Ibexa\\Bundle\\ProductCatalog\\Menu\\CopyFormContextMenuBuilder' => 'Ibexa\\Contracts\\AdminUi\\Menu\\CopyFormContextMenuBuilder',
            'Ibexa\\Bundle\\ProductCatalog\\Menu\\CreateFormContextMenuBuilder' => 'Ibexa\\Contracts\\AdminUi\\Menu\\CreateFormContextMenuBuilder',
            'Ibexa\\Bundle\\ProductCatalog\\Menu\\UpdateFormContextMenuBuilder' => 'Ibexa\\Contracts\\AdminUi\\Menu\\UpdateFormContextMenuBuilder',
        ]
    );

    $rectorConfig->ruleWithConfiguration(
        RenameMethodRector::class,
        [
            new MethodCallRename(
                'Ibexa\\Core\\MVC\\Symfony\\Controller\\Controller',
                'getTemplateEngine',
                'getTwig'
            ),
            new MethodCallRename(
                'Ibexa\\Dashboard\\Migration\\AssignDashboardToUser',
                'getValue',
                'getUserLogin'
            ),
            new MethodCallRename(
                'Ibexa\\Migration\\ValueObject\\Step\\Action\\Content\\AssignParentLocation',
                'getValue',
                'getLocationId'
            ),
            new MethodCallRename(
                'Ibexa\\Migration\\ValueObject\\Step\\Action\\ContentType\\AssignContentTypeGroup',
                'getValue',
                'getGroupName'
            ),
            new MethodCallRename(
                'Ibexa\\Migration\\ValueObject\\Step\\Action\\ContentType\\UnassignContentTypeGroup',
                'getValue',
                'getGroupName'
            ),
            new MethodCallRename(
                'Ibexa\\Migration\\ValueObject\\Step\\Action\\ContentType\\RemoveFieldByIdentifier',
                'getValue',
                'getIdentifier'
            ),
            new MethodCallRename(
                'Ibexa\\Contracts\\ProductCatalog\\Values\\Availability\\AvailabilityInterface',
                'isAvailable',
                'getComputedAvailability'
            ),
            new MethodCallRename(
                'Ibexa\\Bundle\\ProductCatalog\\UI\\ProductSelector\\BaseProduct',
                'getBasePrice',
                'getPrice'
            ),
            new MethodCallRename(
                'Ibexa\\Bundle\\ProductCatalog\\UI\\ProductSelector\\BaseProduct',
                'setBasePrice',
                'setPrice'
            ),
        ]
    );

    $rectorConfig->ruleWithConfiguration(
        RenameClassConstFetchRector::class,
        [
            new RenameClassAndConstFetch(
                'Ibexa\\Contracts\\TranslationsManagement\\AutoTranslate\\DependencyInjection\\AutoTranslateServiceTags',
                'PROVIDER_LANGUAGE_NORMALIZER',
                'Ibexa\\Contracts\\TranslationsManagement\\AutoTranslate\\Provider\\LanguageNormalizer\\LanguageNormalizerInterface',
                'SERVICE_TAG'
            ),
            new RenameClassAndConstFetch(
                'Ibexa\\Contracts\\TranslationsManagement\\AutoTranslate\\DependencyInjection\\AutoTranslateServiceTags',
                'PROVIDER_AI_TRANSLATION_STRATEGY',
                'Ibexa\\TranslationsManagement\\AutoTranslate\\Ai\\AiTranslationStrategyInterface',
                'SERVICE_TAG'
            ),
            new RenameClassAndConstFetch(
                'Ibexa\\Contracts\\TranslationsManagement\\AutoTranslate\\DependencyInjection\\AutoTranslateServiceTags',
                'REVIEW_STATUS_CONTEXT_RESOLVER',
                'Ibexa\\TranslationsManagement\\AutoTranslate\\ReviewStatus\\ContextResolver\\ContextResolverInterface',
                'SERVICE_TAG'
            ),
            new RenameClassAndConstFetch(
                'Ibexa\\AdminUi\\Component\\Event\\RenderGroupEvent',
                'NAME',
                'Ibexa\\Contracts\\TwigComponents\\Event\\RenderGroupEvent',
                'class'
            ),
            new RenameClassAndConstFetch(
                'Ibexa\\AdminUi\\Component\\Event\\RenderSingleEvent',
                'NAME',
                'Ibexa\\Contracts\\TwigComponents\\Event\\RenderSingleEvent',
                'class'
            ),
        ]
    );

    $rectorConfig->ruleWithConfiguration(
        AddReturnTypeDeclarationRector::class,
        [
            new AddReturnTypeDeclaration(
                'Ibexa\\FieldTypePage\\FieldType\\Page\\Block\\Definition\\Attribute\\Validator\\ConstraintFactory',
                'getConstraint',
                new ObjectType('Symfony\\Component\\Validator\\Constraint')
            ),
        ]
    );

    $rectorConfig->skip(
        [
            // skip removing `createView` method call from `Form` objects, per SF 7 recommendation
            SimplifyFormRenderingRector::class,
        ]
    );
};
