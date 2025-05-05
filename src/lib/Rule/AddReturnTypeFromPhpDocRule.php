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
     * @var MethodReturnTypeConfiguration[]
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
abstract class BaseClass 
{
    /** @return SomeObject */
    abstract public function someFunction();
}

class SomeClass extends BaseClass
{
    /** @return SomeObject */
    public function someFunction()
    {
    }
}
CODE_SAMPLE
                    ,
                    <<<'CODE_SAMPLE'
abstract class BaseClass 
{
    /** @return SomeObject */
    abstract public function someFunction();
}

class SomeClass extends BaseClass
{
    public function someFunction(): SomeObject
    {
    }
}
CODE_SAMPLE
                    ,
                    [
                        new MethodReturnTypeConfiguration(
                            'BaseClass',
                            'someFunction',
                        ),
                    ]
                ),
            ]
        );
    }

    private function getReturnTypeFromPhpDoc(ClassMethod $node, string $methodName): ?Node\Name
    {
        foreach ($this->methodConfigurations as $methodConfiguration) {
            if ($methodName !== $methodConfiguration->getMethod()) {
                continue;
            }

            $currentClass = $node->getAttribute('scope')->getClassReflection();
            if (!$currentClass) {
                continue;
            }

            // Check parent hierarchy
            $parentClass = $currentClass->getParentClass();
            while ($parentClass !== null) {
                if ($parentClass->getName() === $methodConfiguration->getClass()) {
                    $phpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($node);
                    $returnType = $phpDocInfo->getReturnType();

                    if (!$returnType instanceof MixedType) {
                        return $this->staticTypeMapper->mapPHPStanTypeToPhpParserNode($returnType, TypeKind::RETURN);
                    }
                }
                $parentClass = $parentClass->getParentClass();
            }

            // Check interfaces
            foreach ($currentClass->getInterfaces() as $interface) {
                if ($interface->getName() === $methodConfiguration->getClass()) {
                    $phpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($node);
                    $returnType = $phpDocInfo->getReturnType();

                    if (!$returnType instanceof MixedType) {
                        return $this->staticTypeMapper->mapPHPStanTypeToPhpParserNode($returnType, TypeKind::RETURN);
                    }
                }
            }
        }

        return null;
    }

    public function refactor(Node $node): ?Node
    {
        if (!$node instanceof ClassMethod || $node->returnType !== null) {
            return null;
        }

        $methodName = $this->getName($node);
        if ($methodName === null) {
            return null;
        }

        $returnType = $this->getReturnTypeFromPhpDoc($node, $methodName);
        if ($returnType === null) {
            return null;
        }

        $node->returnType = $returnType;
        return $node;
    }

    /**
     * @param MethodReturnTypeConfiguration[] $configuration
     */
    public function configure(array $configuration): void
    {
        $this->methodConfigurations = $configuration;
    }
}
