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
        // the new chain takes no arguments, don't guess where old ones would go
        if ($node->args !== []) {
            return null;
        }

        foreach ($this->configurations as $configuration) {
            if (!$this->isName($node->name, $configuration->getOldMethod())
                || !$this->isObjectType($node->var, new ObjectType($configuration->getType()))
            ) {
                continue;
            }

            $newMethods = $configuration->getNewMethods();
            $first = array_shift($newMethods);
            // $a?->b()->c() short-circuits the whole chain, so only the first call stays nullsafe
            $chain = $node instanceof NullsafeMethodCall
                ? new NullsafeMethodCall($node->var, $first)
                : new MethodCall($node->var, $first);
            foreach ($newMethods as $method) {
                $chain = new MethodCall($chain, $method);
            }

            return $chain;
        }

        return null;
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
