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
use PhpParser\Node\Expr\Cast\String_ as StringCast;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\NullsafeMethodCall;
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
 * true, ints and null are passed as the strings 5.0 sent.
 *
 * @see RestVisitorSetHeaderRectorTest
 */
final class RestVisitorSetHeaderRector extends AbstractRector
{
    private const string VISITOR_CLASS = 'Ibexa\Contracts\Rest\Output\Visitor';

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'Replace Visitor::setHeader($name, false) with suppressHeader($name) and pass true, ints and null as strings',
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

        // strings are fine, a bool that may be either value needs a human
        return null;
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
