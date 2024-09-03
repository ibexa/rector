<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Rector\Rule;

use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use PHPStan\Type\ObjectType;
use Rector\Contract\Rector\ConfigurableRectorInterface;
use Rector\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

final class RemoveArgumentFromMethodCallRector extends AbstractRector implements ConfigurableRectorInterface
{
    private int $argumentIndex;

    private string $className;

    private string $methodName;

    private int $moreThan;

    /**
     * @throws \Exception
     */
    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition('Remove legacy eZ Systems & Ibexa class_alias calls', [new ConfiguredCodeSample(
            <<<'CODE_SAMPLE'
class SomeClass
{
    public function someMethod($a, $b, $c = null) {}
}

$instance = new SomeClass();
$instance->someMethod('arg1', 'arg2', 'arg3');
CODE_SAMPLE
            ,
            <<<'CODE_SAMPLE'
class SomeClass
{
    public function someMethod($a, $b, $c) {}
}

$instance = new SomeClass();
$instance->someMethod('arg1', 'arg2');
CODE_SAMPLE
            ,
            ['var_dump']
        )]);
    }

    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes(): array
    {
        return [MethodCall::class];
    }

    /**
     * @param \PhpParser\Node\Expr\MethodCall $node
     */
    public function refactor(Node $node): ?Node
    {
        $className = $this->resolveClassName($node);
        if ($className !== $this->className) {
            return null;
        }
        if ($this->nodeNameResolver->isName($node->name, $this->methodName)
            && count($node->args) > $this->moreThan
        ) {
            if (isset($node->args[$this->argumentIndex])) {
                unset($node->args[$this->argumentIndex]);
                $node->args = array_values($node->args);
            }
        }

        return $node;
    }

    private function resolveClassName(MethodCall $methodCall): ?string
    {
        $type = $this->nodeTypeResolver->getType($methodCall->var);

        if ($type instanceof ObjectType) {
            return $type->getClassName();
        }

        return null;
    }

    public function configure(array $configuration): void
    {
        $this->argumentIndex = (int)$configuration['argument_index_to_remove'];
        $this->className = $configuration['class_name'];
        $this->methodName = $configuration['method_name'];

        //Used to protect already renamed methods.
        $this->moreThan = (int)$configuration['more_than'];
    }
}
