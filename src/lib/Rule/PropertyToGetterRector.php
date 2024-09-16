<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Rector\Rule;

use PhpParser\Node;
use PhpParser\Node\Expr\PropertyFetch;
use PHPStan\Type\ObjectType;
use Rector\Contract\Rector\ConfigurableRectorInterface;
use Rector\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

final class PropertyToGetterRector extends AbstractRector implements ConfigurableRectorInterface
{
    /** @var array<string, array<string, string>> */
    private array $classPropertyToGetterMap = [];

    /**
     * @throws \Exception
     */
    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition('Change direct property access to getter method for specified classes and properties', [new ConfiguredCodeSample(
            <<<'CODE_SAMPLE'
                class SomeClass
                {
                    private $property;
                    public function getProperty() {}
                }
                
                $instance = new SomeClass();
                $instance->property;
            CODE_SAMPLE,
            <<<'CODE_SAMPLE'
                $instance = new SomeClass();
                $instance->getProperty();
            CODE_SAMPLE,
            ['var_dump']
        )]);
    }

    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes(): array
    {
        return [PropertyFetch::class];
    }

    /**
     * @param \PhpParser\Node\Expr\PropertyFetch $node
     */
    public function refactor(Node $node): ?Node
    {
        $className = $this->resolveClassName($node);
        if ($className === null || !isset($this->classPropertyToGetterMap[$className])) {
            return null;
        }

        $propertyName = $this->getName($node->name);

        if (!isset($this->classPropertyToGetterMap[$className][$propertyName])) {
            return null;
        }

        $getterMethodName = $this->classPropertyToGetterMap[$className][$propertyName];

        return $this->nodeFactory->createMethodCall($node->var, $getterMethodName);
    }

    private function resolveClassName(PropertyFetch $propertyFetch): ?string
    {
        $type = $this->nodeTypeResolver->getType($propertyFetch->var);

        if ($type instanceof ObjectType) {
            return $type->getClassName();
        }

        return null;
    }

    public function configure(array $configuration): void
    {
        $this->classPropertyToGetterMap = $configuration;
    }
}
