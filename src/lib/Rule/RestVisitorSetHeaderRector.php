<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Rector\Rule;

use Ibexa\Rector\Tests\Rule\RestVisitorSetHeaderRector\RestVisitorSetHeaderRectorTest;
use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\Cast\String_ as StringCast;
use PhpParser\Node\Expr\ClassConstFetch;
use PhpParser\Node\Expr\ConstFetch;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\NullsafeMethodCall;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\Ternary;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Identifier;
use PhpParser\Node\Scalar\Int_;
use PhpParser\Node\Scalar\String_;
use PHPStan\Type\IntegerType;
use PHPStan\Type\NullType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\StringType;
use PHPStan\Type\TypeCombinator;
use Rector\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

/**
 * ibexa/rest 6.0 narrowed Visitor::setHeader() to a string value: false now goes through suppressHeader(),
 * true, ints and null are passed as the strings 5.0 sent, a bool value branches between setHeader() and suppressHeader().
 *
 * @see RestVisitorSetHeaderRectorTest
 */
final class RestVisitorSetHeaderRector extends AbstractRector
{
    private const string VISITOR_CLASS = 'Ibexa\Contracts\Rest\Output\Visitor';

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'Replace Visitor::setHeader($name, false) with suppressHeader($name), branch on bool values and pass true, ints and null as strings',
            [
                new CodeSample(
                    <<<'CODE_SAMPLE'
                        $visitor->setHeader('Accept-Patch', false);
                        $visitor->setHeader('Content-Length', 0);
                        CODE_SAMPLE,
                    <<<'CODE_SAMPLE'
                        $visitor->suppressHeader('Accept-Patch');
                        $visitor->setHeader('Content-Length', '0');
                        CODE_SAMPLE
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
        if (!$this->isName($node->name, 'setHeader')
            || $node->isFirstClassCallable()
            || !$this->isObjectType($node->var, new ObjectType(self::VISITOR_CLASS))
        ) {
            return null;
        }

        [$nameArg, $valueArg] = $this->resolveArgs($node->getArgs());
        if ($nameArg === null || $valueArg === null) {
            return null;
        }

        $valueType = $this->getType($valueArg->value);
        if ($valueType->isFalse()->yes()) {
            $node->name = new Identifier('suppressHeader');
            $node->args = [$nameArg];

            return $node;
        }

        if ($valueType->isTrue()->yes()) {
            $valueArg->value = new String_('1');

            return $node;
        }

        // 5.0 sent null as an empty header; int|string gets a cast too, a string value just passes through it
        if (TypeCombinator::union(new IntegerType(), new StringType(), new NullType())->isSuperTypeOf($valueType)->yes()
            && !$valueType->isString()->yes()
        ) {
            $valueArg->value = match (true) {
                $valueArg->value instanceof Int_ => new String_((string)$valueArg->value->value),
                $valueType->isNull()->yes() => new String_(''),
                default => new StringCast($valueArg->value),
            };

            return $node;
        }

        // either value is possible, so branch on it; the visitor and name are repeated, only safe without side effects
        if ($valueType->isBoolean()->yes() && $this->isSafeToRepeat($node->var) && $this->isSafeToRepeat($nameArg->value)) {
            $setValueArg = clone $valueArg;
            $setValueArg->value = new String_('1');
            $set = clone $node;
            $set->args = array_map(static fn (Node $arg): Node => $arg === $valueArg ? $setValueArg : $arg, $node->args);
            $suppress = clone $node;
            $suppress->name = new Identifier('suppressHeader');
            $suppress->args = [$nameArg];

            return new Ternary($valueArg->value, $set, $suppress);
        }

        return null;
    }

    private function isSafeToRepeat(Expr $expr): bool
    {
        return $expr instanceof Variable
            || ($expr instanceof PropertyFetch && $expr->var instanceof Variable)
            || $expr instanceof String_
            || $expr instanceof ClassConstFetch
            || $expr instanceof ConstFetch;
    }

    /**
     * @param array<Arg> $args
     *
     * @return array{?Arg, ?Arg}
     */
    private function resolveArgs(array $args): array
    {
        $nameArg = null;
        $valueArg = null;
        foreach (array_values($args) as $position => $arg) {
            $argName = $arg->name?->toString();
            if ($argName === 'name' || ($argName === null && $position === 0)) {
                $nameArg = $arg;
            } elseif ($argName === 'value' || ($argName === null && $position === 1)) {
                $valueArg = $arg;
            }
        }

        return [$nameArg, $valueArg];
    }
}
