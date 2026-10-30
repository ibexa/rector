<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Rector\Rule;

use Ibexa\Rector\Rule\Configuration\AddParentConstructorArgumentConfiguration;
use Ibexa\Rector\Tests\Rule\AddParentConstructorArgumentRector\AddParentConstructorArgumentRectorTest;
use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Identifier;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\Param;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Expression;
use PHPStan\Type\ObjectType;
use Rector\Contract\Rector\ConfigurableRectorInterface;
use Rector\Rector\AbstractRector;
use Rector\ValueObject\MethodName;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

/**
 * Adds a constructor dependency required by a parent class to its subclasses and forwards it to
 * the parent::__construct() call, e.g. when a new service argument is appended to a base class
 * constructor.
 *
 * @see AddParentConstructorArgumentRectorTest
 */
final class AddParentConstructorArgumentRector extends AbstractRector implements ConfigurableRectorInterface
{
    /** @var array<AddParentConstructorArgumentConfiguration> */
    private array $configurations = [];

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'Add an argument required by a parent constructor to subclass constructors and forward it to parent::__construct()',
            [
                new CodeSample(
                    <<<'CODE_SAMPLE'
                        final class Handler extends CriterionHandler
                        {
                            public function __construct(Connection $connection)
                            {
                                parent::__construct($connection);
                            }
                        }
                        CODE_SAMPLE,
                    <<<'CODE_SAMPLE'
                        final class Handler extends CriterionHandler
                        {
                            public function __construct(Connection $connection, JoinedTablesTracker $joinedTablesTracker)
                            {
                                parent::__construct($connection, $joinedTablesTracker);
                            }
                        }
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
        return [Class_::class];
    }

    /**
     * @param Class_ $node
     */
    public function refactor(Node $node): ?Node
    {
        $constructor = $node->getMethod(MethodName::CONSTRUCT);
        if ($constructor === null) {
            return null;
        }

        $hasChanged = false;
        foreach ($this->configurations as $configuration) {
            if ($this->isName($node, $configuration->getParentClass())
                || !$this->isObjectType($node, new ObjectType($configuration->getParentClass()))
            ) {
                continue;
            }

            $parentCall = $this->findParentConstructorCall($constructor);
            // only extend calls passing exactly the arguments before the new one, anything else needs a human
            if ($parentCall === null || count($parentCall->args) !== $configuration->getPosition()) {
                continue;
            }

            $argumentName = $this->resolveArgumentName($constructor, $configuration);

            $arg = new Arg(new Variable($argumentName));
            foreach ($parentCall->getArgs() as $existingArg) {
                if ($existingArg->name !== null) {
                    $arg->name = new Identifier($configuration->getArgumentName());
                    break;
                }
            }
            $parentCall->args[] = $arg;
            $hasChanged = true;
        }

        return $hasChanged ? $node : null;
    }

    private function findParentConstructorCall(ClassMethod $constructor): ?StaticCall
    {
        foreach ($constructor->stmts ?? [] as $stmt) {
            if ($stmt instanceof Expression
                && $stmt->expr instanceof StaticCall
                && $this->isName($stmt->expr->class, 'parent')
                && $this->isName($stmt->expr->name, MethodName::CONSTRUCT)
                && !$stmt->expr->isFirstClassCallable()
            ) {
                return $stmt->expr;
            }
        }

        return null;
    }

    /**
     * Reuses an already injected argument of the required type, otherwise adds a new constructor parameter.
     */
    private function resolveArgumentName(
        ClassMethod $constructor,
        AddParentConstructorArgumentConfiguration $configuration
    ): string {
        foreach ($constructor->params as $param) {
            if ($param->type !== null
                && $this->isName($param->type, $configuration->getArgumentType())
                && $param->var instanceof Variable
                && is_string($param->var->name)
            ) {
                return $param->var->name;
            }
        }

        $newParam = new Param(
            new Variable($configuration->getArgumentName()),
            null,
            new FullyQualified($configuration->getArgumentType())
        );

        // a required parameter must precede optional and variadic ones
        $position = count($constructor->params);
        foreach ($constructor->params as $index => $param) {
            if ($param->default !== null || $param->variadic) {
                $position = $index;
                break;
            }
        }
        array_splice($constructor->params, $position, 0, [$newParam]);

        return $configuration->getArgumentName();
    }

    public function configure(array $configuration): void
    {
        foreach ($configuration as $c) {
            $this->configurations[] = $c;
        }
    }
}
