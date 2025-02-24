<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Rector\Rule\Internal;

use PhpParser\Builder\Method;
use PhpParser\Node;
use PhpParser\Node\Expr\ClassConstFetch;
use PhpParser\Node\Expr\ConstFetch;
use PhpParser\Node\Name;
use Rector\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

final class CacheableSupportsMethodInterfaceRector extends AbstractRector
{
    private const CACHEABLE_SUPPORTS_METHOD_INTERFACE_FQCN = 'Symfony\Component\Serializer\Normalizer\CacheableSupportsMethodInterface';

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            sprintf('Replace %s usage with etSupportedTypes(?string $format) method', self::CACHEABLE_SUPPORTS_METHOD_INTERFACE_FQCN),
            []
        );
    }

    public function getNodeTypes(): array
    {
        return [Node\Stmt\Class_::class];
    }

    /**
     * @param \PhpParser\Node\Stmt\Class_ $node
     */
    public function refactor(Node $node)
    {
        $idx = $this->isCacheableSupportsMethodInterface($node);
        if ($idx === -1) {
            return null;
        }

        $supportsNormalizationMethod = $node->getMethod('supportsNormalization');
        if ($supportsNormalizationMethod === null) {
            return null;
        }

        $type = $this->getSupportedTypes($supportsNormalizationMethod);
        if ($type === null) {
            return null;
        }

        // Remove \Symfony\Component\Serializer\Normalizer\CacheableSupportsMethodInterface from implements
        unset($node->implements[$idx]);

        // Remove \Symfony\Component\Serializer\Normalizer\CacheableSupportsMethodInterface::hasCacheableSupportsMethod method
        $hasCacheableSupportsMethod = $node->getMethod('hasCacheableSupportsMethod');

        $node->stmts = array_filter(
            $node->stmts,
            static function ($stmt) use ($hasCacheableSupportsMethod) {
                return $stmt !== $hasCacheableSupportsMethod;
            }
        );

        // Add getSupportedTypes method
        $getSupportedTypesMethod = new Method('getSupportedTypes');
        $getSupportedTypesMethod->makePublic();
        $getSupportedTypesMethod->setReturnType('array');
        $getSupportedTypesMethod->addParam(new Node\Param(new Node\Expr\Variable('format'), null, '?string'));
        $getSupportedTypesMethod->addStmt(
            new Node\Stmt\Return_(
                new Node\Expr\Array_([
                    new Node\Expr\ArrayItem(
                        new ConstFetch(new Name('true')),
                        new ClassConstFetch(new Name('\\' . $type), 'class')
                    ),
                ])
            )
        );

        $node->stmts[] = $getSupportedTypesMethod->getNode();

        return $node;
    }

    private function getSupportedTypes(Node\Stmt\ClassMethod $node): ?string
    {
        foreach ($node->stmts as $stmt) {
            if ($stmt instanceof Node\Stmt\Return_) {
                $returnExpr = $stmt->expr;
                if ($returnExpr instanceof Node\Expr\Instanceof_) {
                    return $returnExpr->class->toString();
                }
            }
        }

        return null;
    }

    private function isCacheableSupportsMethodInterface(Node\Stmt\Class_ $node): int
    {
        foreach ($node->implements as $i => $implement) {
            if ($implement->toString() === self::CACHEABLE_SUPPORTS_METHOD_INTERFACE_FQCN) {
                return $i;
            }
        }

        return -1;
    }
}
