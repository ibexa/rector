<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Rector\Rule;

use Ibexa\Rector\Rule\Configuration\MethodCallToChainedMethodCallConfiguration;
use Ibexa\Rector\Tests\Rule\MethodCallToChainedMethodCallRector\MethodCallToChainedMethodCallRectorTest;
use InvalidArgumentException;
use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\NullsafeMethodCall;
use PHPStan\Type\ObjectType;
use PHPStan\Type\TypeCombinator;
use Rector\Contract\Rector\ConfigurableRectorInterface;
use Rector\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

/**
 * Replaces a removed method with a chain of calls, e.g. $struct->getId() with $struct->getPrice()->getId(),
 * which RenameMethodRector can't express.
 *
 * @see MethodCallToChainedMethodCallRectorTest
 */
final class MethodCallToChainedMethodCallRector extends AbstractRector implements ConfigurableRectorInterface
{
    /** @var list<MethodCallToChainedMethodCallConfiguration> */
    private array $configurations = [];

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'Replace a method call with a chain of method calls on the same receiver',
            [
                new ConfiguredCodeSample(
                    '$struct->getId();',
                    '$struct->getPrice()->getId();',
                    [new MethodCallToChainedMethodCallConfiguration('Ibexa\Contracts\ProductCatalog\Values\Price\Update\Struct\ProductPriceUpdateStructInterface', 'getId', ['getPrice', 'getId'])]
                ),
            ]
        );
    }

    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes(): array
    {
        return [MethodCall::class, NullsafeMethodCall::class];
    }

    /**
     * @param MethodCall|NullsafeMethodCall $node
     */
    public function refactor(Node $node): ?Node
    {
        // the new chain takes no arguments, don't guess where old ones would go; $a->b(...) moves to the last call
        if ($node->args !== [] && !$node->isFirstClassCallable()) {
            return null;
        }

        $receiverType = TypeCombinator::removeNull($this->getType($node->var));

        // a union receiver (A|B) is rewritten when every member is configured with the same chain
        $typesByChain = [];
        $chains = [];
        foreach ($this->configurations as $configuration) {
            if (!$this->isName($node->name, $configuration->getOldMethod())) {
                continue;
            }

            $key = implode('->', $configuration->getNewMethods());
            $typesByChain[$key][] = new ObjectType($configuration->getType());
            $chains[$key] = $configuration->getNewMethods();
        }

        foreach ($typesByChain as $key => $types) {
            if (TypeCombinator::union(...$types)->isSuperTypeOf($receiverType)->yes()) {
                return $this->createChain($node, $chains[$key]);
            }
        }

        return null;
    }

    /**
     * @param non-empty-list<string> $newMethods
     */
    private function createChain(
        MethodCall | NullsafeMethodCall $node,
        array $newMethods
    ): MethodCall | NullsafeMethodCall {
        $first = array_shift($newMethods);
        // $a?->b()->c() short-circuits the whole chain, so only the first call stays nullsafe
        $chain = $node instanceof NullsafeMethodCall
            ? new NullsafeMethodCall($node->var, $first)
            : new MethodCall($node->var, $first);
        foreach ($newMethods as $method) {
            $chain = new MethodCall($chain, $method);
        }
        $chain->args = $node->args;

        return $chain;
    }

    public function configure(array $configuration): void
    {
        foreach ($configuration as $c) {
            if (!$c instanceof MethodCallToChainedMethodCallConfiguration) {
                throw new InvalidArgumentException(sprintf(
                    '%s expects a list of %s, got %s',
                    self::class,
                    MethodCallToChainedMethodCallConfiguration::class,
                    get_debug_type($c),
                ));
            }

            $this->configurations[] = $c;
        }
    }
}
