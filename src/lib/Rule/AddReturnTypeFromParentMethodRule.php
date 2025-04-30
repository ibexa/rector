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
use PHPStan\Type\VerbosityLevel;
use Rector\Contract\Rector\ConfigurableRectorInterface;
use Rector\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

final class AddReturnTypeFromParentMethodRule extends AbstractRector implements ConfigurableRectorInterface
{
    private MethodReturnTypeConfiguration $methodConfiguration;

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'Add return type from parent class or interface method implementation',
            [
                new ConfiguredCodeSample(
                    <<<'CODE_SAMPLE'
                    interface SomeInterface
                    {
                        public function someFunction(): SomeObject;
                    }
                    
                    class SomeClass implements SomeInterface
                    {
                        public function someFunction()
                        {
                        }
                    }
                    CODE_SAMPLE
                    ,
                    <<<'CODE_SAMPLE'
                    interface SomeInterface
                    {
                        public function someFunction(): SomeObject;
                    }
                    
                    class SomeClass implements SomeInterface
                    {
                        public function someFunction(): SomeObject
                        {
                        }
                    }
                    CODE_SAMPLE
                    ,
                    [
                        new MethodReturnTypeConfiguration(
                            'SomeInterface',
                            'someFunction'
                        ),
                    ]
                ),
            ]
        );
    }

    public function getNodeTypes(): array
    {
        return [ClassMethod::class];
    }

    private function getMethodReturnType(ClassReflection $classOrInterface, string $methodName): ?string
    {
        if ($classOrInterface->getName() !== $this->methodConfiguration->getClass()
            || $methodName !== $this->methodConfiguration->getMethod()) {
            return null;
        }

        $method = $classOrInterface->getNativeMethod($methodName);

        $variants = $method->getVariants();
        if (!isset($variants[0])) {
            return null;
        }

        $returnType = $variants[0]->getReturnType();

        return $returnType->describe(VerbosityLevel::typeOnly());
    }

    private function tryGetReturnTypeFromParent(ClassReflection $currentClass, string $methodName): ?string
    {
        $parentClass = $currentClass->getParentClass();

        return $parentClass ? $this->getMethodReturnType($parentClass, $methodName) : null;
    }

    private function tryGetReturnTypeFromInterfaces(ClassReflection $currentClass, string $methodName): ?string
    {
        foreach ($currentClass->getInterfaces() as $interface) {
            $typeName = $this->getMethodReturnType($interface, $methodName);
            if ($typeName !== null) {
                return $typeName;
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

        $currentClass = $node->getAttribute('scope')->getClassReflection();
        if ($currentClass === null) {
            return null;
        }

        $typeName = $this->tryGetReturnTypeFromParent($currentClass, $methodName)
            ?? $this->tryGetReturnTypeFromInterfaces($currentClass, $methodName);

        if ($typeName === null) {
            return null;
        }

        $node->returnType = $this->createReturnTypeNode($typeName);

        return $node;
    }

    private function createReturnTypeNode(?string $typeName): ?Node\Name
    {
        return $typeName !== null ? new Node\Name($typeName) : null;
    }

    /**
     * @param \Ibexa\Rector\Rule\Configuration\MethodReturnTypeConfiguration[] $configuration
     */
    public function configure(array $configuration): void
    {
        $this->methodConfiguration = $configuration[0];
    }
}
