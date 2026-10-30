<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Rector\Rule;

use Ibexa\Rector\Tests\Rule\PlatformGetNameToDatabasePlatformResolverRector\PlatformGetNameToDatabasePlatformResolverRectorTest;
use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\BinaryOp\Identical;
use PhpParser\Node\Expr\ConstFetch;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\NullsafeMethodCall;
use PhpParser\Node\Expr\NullsafePropertyFetch;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Expr\Ternary;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Name;
use PhpParser\Node\Name\FullyQualified;
use PHPStan\Type\ObjectType;
use PHPStan\Type\Type;
use PHPStan\Type\TypeCombinator;
use Rector\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

/**
 * Doctrine DBAL 4 removed AbstractPlatform::getName(), ibexa/doctrine-schema's DatabasePlatformResolver replaces it.
 * Same names for MySQL/MariaDB, PostgreSQL and SQLite; platforms Ibexa does not support resolve to null.
 *
 * @see PlatformGetNameToDatabasePlatformResolverRectorTest
 */
final class PlatformGetNameToDatabasePlatformResolverRector extends AbstractRector
{
    private const string PLATFORM_CLASS = 'Doctrine\DBAL\Platforms\AbstractPlatform';

    private const string RESOLVER_CLASS = 'Ibexa\Contracts\DoctrineSchema\Database\DatabasePlatformResolver';

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'Replace AbstractPlatform::getName() with DatabasePlatformResolver::resolveName(), which returns null for platforms other than MySQL/MariaDB, PostgreSQL and SQLite',
            [
                new CodeSample(
                    '$connection->getDatabasePlatform()->getName();',
                    '\\' . self::RESOLVER_CLASS . '::resolveName($connection->getDatabasePlatform())?->value;'
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
        $receiverType = $this->getType($node->var);
        $platformType = TypeCombinator::removeNull($receiverType);
        if (!$this->isName($node->name, 'getName')
            || !(new ObjectType(self::PLATFORM_CLASS))->isSuperTypeOf($platformType)->yes()
            || $this->hasOwnGetName($platformType)
        ) {
            return null;
        }

        $resolvedName = new NullsafePropertyFetch(
            new StaticCall(new FullyQualified(self::RESOLVER_CLASS), 'resolveName', [new Arg($node->var)]),
            'value'
        );

        if (!$node instanceof NullsafeMethodCall && !TypeCombinator::containsNull($receiverType)) {
            return $resolvedName;
        }

        // resolveName() takes no null; only guard receivers that are safe to evaluate twice, anything else needs a human
        if (!$node->var instanceof Variable
            && !($node->var instanceof PropertyFetch && $node->var->var instanceof Variable)
        ) {
            return null;
        }

        return new Ternary(
            new Identical(clone $node->var, new ConstFetch(new Name('null'))),
            new ConstFetch(new Name('null')),
            $resolvedName
        );
    }

    /**
     * A custom platform declaring its own getName() keeps it, only DBAL's (removed in DBAL 4) is replaced.
     */
    private function hasOwnGetName(Type $platformType): bool
    {
        foreach ($platformType->getObjectClassReflections() as $classReflection) {
            if ($classReflection->hasNativeMethod('getName')
                && !str_starts_with($classReflection->getNativeMethod('getName')->getDeclaringClass()->getName(), 'Doctrine\DBAL\\')
            ) {
                return true;
            }
        }

        return false;
    }
}
