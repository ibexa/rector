<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Rector\Rule\Internal;

use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitorAbstract;
use Rector\Contract\Rector\ConfigurableRectorInterface;
use Rector\NodeNameResolver\NodeNameResolver;
use Rector\Rector\AbstractRector;
use Rector\Removing\Rector\Class_\RemoveInterfacesRector;
use ReflectionClass;
use ReflectionMethod;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

final class RemoveInterfaceWithMethods extends AbstractRector implements ConfigurableRectorInterface
{
    private RemoveInterfacesRector $removeInterfacesRector;

    /** @var class-string[] */
    private array $interfacesToRemove;

    public function __construct(RemoveInterfacesRector $removeInterfacesRector)
    {
        $this->removeInterfacesRector = $removeInterfacesRector;
    }

    /**
     * @throws \Exception
     */
    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition('Remove Interface implementation with all its methods', [new ConfiguredCodeSample(
            <<<'CODE_SAMPLE'
                class SomeClassWithInterface implements InterfaceToRemove
                {
                    public function interfaceMethod(): array
                    {
                        return ['smth'];
                    }
                }
            CODE_SAMPLE
            ,
            <<<'CODE_SAMPLE'
                class SomeClassWithInterface
                {
                }
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
        return $this->removeInterfacesRector->getNodeTypes();
    }

    /**
     * @param \PhpParser\Node\Stmt\Class_ $node
     */
    public function refactor(Node $node): ?int
    {
        if ($node->implements === []) {
            return null;
        }

        foreach ($node->implements as $implement) {
            if ($this->isNames($implement, $this->interfacesToRemove)) {
                foreach ($this->interfacesToRemove as $interface) {
                    $ref = new ReflectionClass($interface);
                    $methods = array_map(static fn (ReflectionMethod $reflectionMethod) => $reflectionMethod->getName(), $ref->getMethods());

                    // Remove method definition
                    foreach ($node->stmts as $key => $stmt) {
                        if ($stmt instanceof ClassMethod && $this->isNames($stmt, $methods)) {
                            unset($node->stmts[$key]);
                        }
                    }

                    // Remove method calls, if one of the arguments was removed method
                    foreach ($node->getMethods() as $classMethod) {
                        $nodeTraverser = new NodeTraverser();
                        $nodeTraverser->addVisitor(new class($this->nodeNameResolver, $methods) extends NodeVisitorAbstract {
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
                        });

                        if ($classMethod->stmts !== null) {
                            /** @var array<\PhpParser\Node\Stmt>|null $traversedStmts */

                            $traversedStmts = $nodeTraverser->traverse($classMethod->stmts);
                            $classMethod->stmts = $traversedStmts;
                        }
                    }
                }
            }
        }

        // Remove interface
        $this->removeInterfacesRector->refactor($node);

        return null;
    }

    /**
     * @param class-string[] $configuration
     */
    public function configure(array $configuration): void
    {
        $this->interfacesToRemove = $configuration;

        $this->removeInterfacesRector->configure($configuration);
    }
}
