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
use Rector\NodeAnalyzer\ArgsAnalyzer;
use Rector\Rector\AbstractRector;
use Rector\Reflection\ReflectionResolver;
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
    /** @var list<AddParentConstructorArgumentConfiguration> */
    private array $configurations = [];

    public function __construct(
        private readonly ArgsAnalyzer $argsAnalyzer,
        private readonly ReflectionResolver $reflectionResolver
    ) {}

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

        $parentCall = $this->findParentConstructorCall($constructor);
        $parentConstructorClass = $this->resolveParentConstructorClass($node);
        if ($parentCall === null || $parentConstructorClass === null) {
            return null;
        }

        $hasChanged = false;
        foreach ($this->configurations as $configuration) {
            if ($parentConstructorClass !== $configuration->getParentClass()
                || $this->isArgumentPassed($parentCall, $configuration)
            ) {
                continue;
            }

            $arg = new Arg(new Variable($configuration->getArgumentName()));
            if ($this->argsAnalyzer->hasNamedArg($parentCall->getArgs())) {
                $arg->name = new Identifier($configuration->getArgumentName());
                $parentCall->args[] = $arg;
            } elseif (count($parentCall->args) >= $configuration->getPosition()) {
                array_splice($parentCall->args, $configuration->getPosition(), 0, [$arg]);
            } else {
                // the call relies on default values before the new argument, needs a human
                continue;
            }

            $this->addConstructorParam($constructor, $configuration);
            $hasChanged = true;
        }

        return $hasChanged ? $node : null;
    }

    /**
     * The class declaring the constructor parent::__construct() resolves to, which can be further up than the direct parent.
     */
    private function resolveParentConstructorClass(Class_ $class): ?string
    {
        $parentClass = $this->reflectionResolver->resolveClassReflection($class)?->getParentClass();
        if ($parentClass === null || !$parentClass->hasConstructor()) {
            return null;
        }

        return $parentClass->getConstructor()->getDeclaringClass()->getName();
    }

    private function isArgumentPassed(
        StaticCall $parentCall,
        AddParentConstructorArgumentConfiguration $configuration
    ): bool {
        foreach ($parentCall->getArgs() as $arg) {
            if ($arg->unpack
                || $this->isName($arg->name ?? $arg->value, $configuration->getArgumentName())
                || $this->isObjectType($arg->value, new ObjectType($configuration->getArgumentType()))
            ) {
                return true;
            }
        }

        return false;
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

    private function addConstructorParam(
        ClassMethod $constructor,
        AddParentConstructorArgumentConfiguration $configuration
    ): void {
        foreach ($constructor->params as $param) {
            if ($this->isName($param, $configuration->getArgumentName())) {
                return;
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
    }

    public function configure(array $configuration): void
    {
        foreach ($configuration as $c) {
            if (!$c instanceof AddParentConstructorArgumentConfiguration) {
                throw new \InvalidArgumentException(sprintf(
                    '%s expects a list of %s, got %s',
                    self::class,
                    AddParentConstructorArgumentConfiguration::class,
                    get_debug_type($c),
                ));
            }

            $this->configurations[] = $c;
        }
    }
}
