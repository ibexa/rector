<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Rector\Rule\Internal;

use PhpParser\Node;
use PhpParser\NodeTraverser;
use Rector\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

/**
 * @internal This rule is internal, for Ibexa 1st party packages
 */
final class RemoveLegacyClassAliasRector extends AbstractRector
{
    /** @var array<string> */
    private const array FQCN_PREFIXES = ['eZ\\', 'EzSystems\\', 'Ibexa\\'];

    /**
     * @throws \Exception
     */
    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition('Remove legacy eZ Systems & Ibexa class_alias calls', [new ConfiguredCodeSample(
            <<<'CODE_SAMPLE'
$x = 'something';
class_alias(Foo::class, 'eZ\Foo');
class_alias(Foo::class, 'Other\ThirdParty\Foo');
CODE_SAMPLE
            ,
            <<<'CODE_SAMPLE'
$x = 'something';
class_alias(Foo::class, 'Other\ThirdParty\Foo');
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
        return [Node\Stmt\Expression::class];
    }

    /**
     * @param \PhpParser\Node\Stmt\Expression $node
     */
    public function refactor(Node $node): ?int
    {
        $expr = $node->expr;
        if (!$expr instanceof Node\Expr\FuncCall) {
            return null;
        }

        $args = $expr->getArgs();
        if (!$this->isName($expr->name, 'class_alias') || !$this->isLegacyClassAlias($args)) {
            return null;
        }

        return NodeTraverser::REMOVE_NODE;
    }

    /**
     * @param \PhpParser\Node\Arg[] $args
     */
    private function isLegacyClassAlias(array $args): bool
    {
        if (!isset($args[1]) || !$args[1]->value instanceof Node\Scalar\String_) {
            return false;
        }

        $value = $args[1]->value->value;

        foreach (self::FQCN_PREFIXES as $prefix) {
            if (str_starts_with($value, $prefix)) {
                return true;
            }
        }

        return false;
    }
}
