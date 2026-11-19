<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Rector\Rule;

use Ibexa\Rector\Rule\Configuration\RemoveParentConstructorArgumentConfiguration;
use Ibexa\Rector\Tests\Rule\RemoveParentConstructorArgumentRector\RemoveParentConstructorArgumentRectorTest;
use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Expression;
use PhpParser\NodeFinder;
use PHPStan\Reflection\ExtendedMethodReflection;
use Rector\Contract\Rector\ConfigurableRectorInterface;
use Rector\NodeAnalyzer\ArgsAnalyzer;
use Rector\Rector\AbstractRector;
use Rector\Reflection\ReflectionResolver;
use Rector\ValueObject\MethodName;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

/**
 * Removes arguments a parent constructor no longer accepts from parent::__construct() calls in its subclasses, dropping subclass constructor parameters left unused.
 *
 * @see RemoveParentConstructorArgumentRectorTest
 */
final class RemoveParentConstructorArgumentRector extends AbstractRector implements ConfigurableRectorInterface
{
    /** @var list<RemoveParentConstructorArgumentConfiguration> */
    private array $configurations = [];

    public function __construct(
        private readonly ArgsAnalyzer $argsAnalyzer,
        private readonly ReflectionResolver $reflectionResolver
    ) {}

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'Remove arguments a parent constructor no longer accepts from parent::__construct() calls in subclasses',
            [
                new CodeSample(
                    <<<'CODE_SAMPLE'
                        final class CustomInstaller extends CoreInstaller
                        {
                            public function __construct(Connection $db, SchemaBuilderInterface $schemaBuilder, bool $doctrineMigrationsEnabled, ?TaggedMigrationsRunner $taggedMigrationsRunner = null)
                            {
                                parent::__construct($db, $schemaBuilder, $doctrineMigrationsEnabled, $taggedMigrationsRunner);
                            }
                        }
                        CODE_SAMPLE,
                    <<<'CODE_SAMPLE'
                        final class CustomInstaller extends CoreInstaller
                        {
                            public function __construct(Connection $db, ?TaggedMigrationsRunner $taggedMigrationsRunner = null)
                            {
                                parent::__construct($db, $taggedMigrationsRunner);
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
        $parentConstructor = $this->resolveParentConstructor($node);
        if ($parentCall === null || $parentConstructor === null || $this->hasUnpackedArg($parentCall)) {
            return null;
        }

        $parentClass = $parentConstructor->getDeclaringClass()->getName();
        $isNamedCall = $this->argsAnalyzer->hasNamedArg($parentCall->getArgs());
        if (!$isNamedCall && !$this->hasMoreArgsThanAccepted($parentCall, $parentConstructor)) {
            return null;
        }

        $args = $parentCall->getArgs();
        $removedArgs = [];
        foreach ($this->configurations as $configuration) {
            if ($parentClass !== $configuration->getParentClass()) {
                continue;
            }

            $index = $isNamedCall
                ? $this->findNamedArgIndex($parentCall, $configuration->getArgumentName())
                : $configuration->getPosition();
            if ($index === null || !isset($args[$index])) {
                continue;
            }

            $removedArgs[] = $args[$index];
            unset($args[$index]);
        }

        if ($removedArgs === []) {
            return null;
        }

        $parentCall->args = array_values($args);
        foreach ($removedArgs as $removedArg) {
            $this->removeUnusedConstructorParam($constructor, $removedArg);
        }

        return $node;
    }

    private function resolveParentConstructor(Class_ $class): ?ExtendedMethodReflection
    {
        $parentClass = $this->reflectionResolver->resolveClassReflection($class)?->getParentClass();
        if ($parentClass === null || !$parentClass->hasConstructor()) {
            return null;
        }

        return $parentClass->getConstructor();
    }

    private function hasUnpackedArg(StaticCall $parentCall): bool
    {
        foreach ($parentCall->getArgs() as $arg) {
            if ($arg->unpack) {
                return true;
            }
        }

        return false;
    }

    private function hasMoreArgsThanAccepted(
        StaticCall $parentCall,
        ExtendedMethodReflection $parentConstructor
    ): bool {
        foreach ($parentConstructor->getVariants() as $variant) {
            if ($variant->isVariadic() || count($parentCall->args) <= count($variant->getParameters())) {
                return false;
            }
        }

        return true;
    }

    private function findNamedArgIndex(
        StaticCall $parentCall,
        string $argumentName
    ): ?int {
        foreach ($parentCall->getArgs() as $index => $arg) {
            if ($arg->name !== null && $this->isName($arg->name, $argumentName)) {
                return $index;
            }
        }

        return null;
    }

    private function removeUnusedConstructorParam(
        ClassMethod $constructor,
        Arg $removedArg
    ): void {
        if (!$removedArg->value instanceof Variable) {
            return;
        }

        $variableName = $this->getName($removedArg->value);
        if ($variableName === null) {
            return;
        }

        $usages = (new NodeFinder())->find(
            $constructor->stmts ?? [],
            fn (Node $node): bool => $node instanceof Variable && $this->isName($node, $variableName)
        );
        if ($usages !== []) {
            return;
        }

        foreach ($constructor->params as $index => $param) {
            if ($param->flags === 0 && $this->isName($param, $variableName)) {
                unset($constructor->params[$index]);
                $constructor->params = array_values($constructor->params);

                return;
            }
        }
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
     * @param list<RemoveParentConstructorArgumentConfiguration> $configuration
     */
    public function configure(array $configuration): void
    {
        $this->configurations = $configuration;

        usort(
            $this->configurations,
            static fn (RemoveParentConstructorArgumentConfiguration $a, RemoveParentConstructorArgumentConfiguration $b): int => $b->getPosition() <=> $a->getPosition()
        );
    }
}
