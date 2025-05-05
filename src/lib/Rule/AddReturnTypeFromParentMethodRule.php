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
    /**
     * @var \Ibexa\Rector\Rule\Configuration\MethodReturnTypeConfiguration[]
     */
    private array $methodConfigurations = [];

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

    private function getMethodReturnTypeFromConfiguredParent(ClassReflection $currentClass, string $methodName): ?string
    {
        foreach ($this->methodConfigurations as $methodConfiguration) {
            $configuredClass = $methodConfiguration->getClass();
            if ($methodName !== $methodConfiguration->getMethod()) {
                continue;
            }

            // Try to find in parent hierarchy
            $classReflection = $currentClass->getParentClass();
            while ($classReflection !== null) {
                if ($classReflection->getName() === $configuredClass) {
                    $method = $classReflection->getNativeMethod($methodName);
                    $variants = $method->getVariants();
                    if (isset($variants[0])) {
                        return $variants[0]->getReturnType()->describe(VerbosityLevel::typeOnly());
                    }
                }
                $classReflection = $classReflection->getParentClass();
            }

            // Try to find in interfaces
            foreach ($currentClass->getInterfaces() as $interface) {
                if ($interface->getName() === $configuredClass) {
                    $method = $interface->getNativeMethod($methodName);
                    $variants = $method->getVariants();
                    if (isset($variants[0])) {
                        return $variants[0]->getReturnType()->describe(VerbosityLevel::typeOnly());
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
        $currentClass = $node->getAttribute('scope')->getClassReflection();
        if ($currentClass === null) {
            return null;
        }

        $typeName = $this->getMethodReturnTypeFromConfiguredParent($currentClass, $methodName);
        if ($typeName === null) {
            return null;
        }

        $node->returnType = new Node\Name($typeName);

        return $node;
    }

    /**
     * @param \Ibexa\Rector\Rule\Configuration\MethodReturnTypeConfiguration[] $configuration
     */
    public function configure(array $configuration): void
    {
        $this->methodConfigurations = $configuration;
    }
}
