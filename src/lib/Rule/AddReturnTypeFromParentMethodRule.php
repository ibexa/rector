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

    public function refactor(Node $node): ?Node
    {
        if (!$node instanceof ClassMethod || $node->returnType !== null) {
            return null;
        }

        $methodName = $this->getName($node);
        if (!$methodName) {
            return null;
        }

        $currentClass = $node->getAttribute('scope')->getClassReflection();
        if (!$currentClass) {
            return null;
        }

        // Check parent classes
        $parentClass = $currentClass->getParentClass();
        if ($parentClass) {
            $typeName = $this->getMethodReturnType($parentClass, $methodName);
            if ($typeName) {
                $node->returnType = new Node\Name($typeName);

                return $node;
            }
        }

        // Check interfaces
        foreach ($currentClass->getInterfaces() as $interface) {
            $typeName = $this->getMethodReturnType($interface, $methodName);
            if ($typeName) {
                $node->returnType = new Node\Name($typeName);

                return $node;
            }
        }

        return null;
    }

    /**
     * @param \Ibexa\Rector\Rule\Configuration\MethodReturnTypeConfiguration[] $configuration
     */
    public function configure(array $configuration): void
    {
        $this->methodConfiguration = $configuration[0];
    }
}
