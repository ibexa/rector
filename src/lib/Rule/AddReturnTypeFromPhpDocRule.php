<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Rector\Rule;

use Ibexa\Rector\Rule\Configuration\MethodReturnTypeConfiguration;
use PhpParser\Node;
use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Type\MixedType;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory;
use Rector\Contract\Rector\ConfigurableRectorInterface;
use Rector\PHPStanStaticTypeMapper\Enum\TypeKind;
use Rector\Rector\AbstractRector;
use Rector\StaticTypeMapper\StaticTypeMapper;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

final class AddReturnTypeFromPhpDocRule extends AbstractRector implements ConfigurableRectorInterface
{
    /**
     * @var \Ibexa\Rector\Rule\Configuration\MethodReturnTypeConfiguration[]
     */
    private array $methodConfigurations = [];

    public function __construct(
        private PhpDocInfoFactory $phpDocInfoFactory,
        private StaticTypeMapper $staticTypeMapper
    ) {
    }

    public function getNodeTypes(): array
    {
        return [ClassMethod::class];
    }

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'Add return type to methods based on their PHPDoc return tag',
            [
                new ConfiguredCodeSample(
                    <<<'CODE_SAMPLE'
                    class SomeClass
                    {
                        /** @return SomeObject */
                        public function someFunction()
                        {
                        }
                    }
                    CODE_SAMPLE
                    ,
                    <<<'CODE_SAMPLE'
                    class SomeClass
                    {
                        public function someFunction(): SomeObject
                        {
                        }
                    }
                    CODE_SAMPLE
                    ,
                    [
                        'configurations' => [
                            new MethodReturnTypeConfiguration(
                                'SomeInterface',
                                'someFunction',
                            ),
                        ],
                    ]
                ),
            ]
        );
    }

    /**
     * @param \PhpParser\Node\Stmt\ClassMethod $node
     */
    public function refactor(Node $node): ?Node
    {
        if ($node->returnType !== null) {
            return null;
        }

        $currentClass = $node->getAttribute('scope')->getClassReflection();
        if (!$currentClass) {
            return null;
        }

        $methodName = $this->getName($node);
        $matchingConfig = $this->findMatchingConfiguration($currentClass, $methodName);

        if ($matchingConfig === null) {
            return null;
        }

        $phpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($node);
        $returnType = $phpDocInfo->getReturnType();

        if ($returnType instanceof MixedType) {
            return null;
        }

        $node->returnType = $this->staticTypeMapper->mapPHPStanTypeToPhpParserNode($returnType, TypeKind::RETURN);

        return $node;
    }

    private function findMatchingConfiguration(ClassReflection $currentClass, string $methodName): ?MethodReturnTypeConfiguration
    {
        foreach ($this->methodConfigurations as $config) {
            foreach ($currentClass->getInterfaces() as $interface) {
                if ($interface->getName() === $config->getClass() && $methodName === $config->getMethod()) {
                    return $config;
                }
            }
        }

        return null;
    }

    /**
     * @param \Ibexa\Rector\Rule\Configuration\MethodReturnTypeConfiguration[] $configuration
     */
    public function configure(array $configuration): void
    {
        $this->methodConfigurations = $configuration;
    }
}
