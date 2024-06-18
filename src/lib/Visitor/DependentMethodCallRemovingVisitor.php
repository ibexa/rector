<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Rector\Visitor;

use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\NodeVisitorAbstract;
use Rector\NodeNameResolver\NodeNameResolver;

/**
 * Removes method call, when one of the methods is used as argument to that method.
 */
final class DependentMethodCallRemovingVisitor extends NodeVisitorAbstract
{
    private NodeNameResolver $nodeNameResolver;

    /** @var string[] */
    private array $methods;

    /**
     * @param string[] $methods
     */
    public function __construct(NodeNameResolver $nodeNameResolver, array $methods)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->methods = $methods;
    }

    public function leaveNode(Node $node)
    {
        if ($node instanceof MethodCall) {
            foreach ($node->getArgs() as $arg) {
                $argValue = $arg->value;
                if ($argValue instanceof MethodCall && $this->nodeNameResolver->isNames($argValue->name, $this->methods)) {
                    return $node->var;
                }
            }
        }

        return null;
    }
}
