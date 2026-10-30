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
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\NullsafePropertyFetch;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Name\FullyQualified;
use PHPStan\Type\ObjectType;
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
        return [MethodCall::class];
    }

    /**
     * @param MethodCall $node
     */
    public function refactor(Node $node): ?Node
    {
        if (!$this->isName($node->name, 'getName')
            // a custom platform calling its own getName() keeps it
            || $this->isName($node->var, 'this')
            || !$this->isObjectType($node->var, new ObjectType(self::PLATFORM_CLASS))
        ) {
            return null;
        }

        return new NullsafePropertyFetch(
            new StaticCall(new FullyQualified(self::RESOLVER_CLASS), 'resolveName', [new Arg($node->var)]),
            'value'
        );
    }
}
