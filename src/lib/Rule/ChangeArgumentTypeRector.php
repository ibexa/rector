<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Rector\Rule;

use Ibexa\Rector\Rule\Configuration\ChangeArgumentTypeConfiguration;
use PhpParser\Node;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Param;
use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\Type\ObjectType;
use PHPStan\Type\ObjectWithoutClassType;
use PHPStan\Type\Type;
use Rector\Contract\Rector\ConfigurableRectorInterface;
use Rector\Exception\ShouldNotHappenException;
use Rector\PHPStanStaticTypeMapper\Enum\TypeKind;
use Rector\Rector\AbstractRector;
use Rector\StaticTypeMapper\StaticTypeMapper;

/**
 * @see \Ibexa\Rector\Tests\Rule\ChangeArgumentTypeRector\ChangeArgumentTypeRectorTest
 */
final class ChangeArgumentTypeRector extends AbstractRector implements ConfigurableRectorInterface
{
    /** @var array<\Ibexa\Rector\Rule\Configuration\ChangeArgumentTypeConfiguration> */
    private array $configurations = [];

    public function __construct(
        private readonly StaticTypeMapper $staticTypeMapper
    ) {
    }

    /**
     * @return array<class-string<\PhpParser\Node>>
     */
    public function getNodeTypes(): array
    {
        return [
            Node\Stmt\Class_::class,
            Node\Stmt\Interface_::class,
        ];
    }

    /**
     * @param \PhpParser\Node\Stmt\Class_|\PhpParser\Node\Stmt\Interface_ $node
     *
     * @return array<\PhpParser\Node>|null
     */
    public function refactor(Node $node): array|null
    {
        $nodes = [];
        foreach ($this->findConfigurationForClass($node) as $configuration) {
            $nextNode = $this->doRefactor($node, $configuration);

            if ($nextNode !== null) {
                $nodes[] = $nextNode;
            }
        }

        return $nodes ?: null;
    }

    /**
     * @param \PhpParser\Node\Stmt\Class_|\PhpParser\Node\Stmt\Interface_ $node
     */
    private function doRefactor(Node $node, ChangeArgumentTypeConfiguration $configuration): ?Node
    {
        $evaluateMethod = $node->getMethod($configuration->getMethod());
        if ($evaluateMethod === null) {
            return null;
        }

        if (!isset($evaluateMethod->params[$configuration->getArgumentPosition()])) {
            return null;
        }

        $param = $evaluateMethod->params[$configuration->getArgumentPosition()];
        if (!$this->isObjectType($param, new ObjectType($configuration->getArgumentClassName()))) {
            return null;
        }

        if (!isset($param->var->name)) {
            throw new ShouldNotHappenException(sprintf(
                'Method %s::%s argument should have a name',
                $configuration->getInterface(),
                $configuration->getMethod(),
            ));
        }

        $newType = $configuration->getNewArgumentClass();
        $newType = $newType === null ? new ObjectWithoutClassType() : new ObjectType($newType);

        $this->addClassMethodParam(
            $configuration,
            $evaluateMethod,
            $newType,
            $param->var->name,
        );

        return $node;
    }

    /**
     * @return iterable<\Ibexa\Rector\Rule\Configuration\ChangeArgumentTypeConfiguration>
     *
     * @throws \PHPStan\ShouldNotHappenException
     */
    private function findConfigurationForClass(
        Node\Stmt\Class_|Node\Stmt\Interface_ $class
    ): iterable {
        foreach ($this->configurations as $configuration) {
            $interface = $configuration->getInterface();
            $objectType = new ObjectType($interface);

            $classType = $this->getType($class);

            if ($objectType->isSuperTypeOf($classType)->yes()) {
                yield $configuration;
            }
        }
    }

    private function addClassMethodParam(
        Configuration\ChangeArgumentTypeConfiguration $configuration,
        ClassMethod $classMethod,
        Type $type,
        string $paramName
    ): void {
        $param = new Param(new Variable($paramName));
        $param->type = $this->staticTypeMapper->mapPHPStanTypeToPhpParserNode($type, TypeKind::PARAM);

        $argumentPosition = $configuration->getArgumentPosition();
        $classMethod->params[$argumentPosition] = $param;
    }

    public function configure(array $configuration): void
    {
        foreach ($configuration as $c) {
            $this->configurations[] = $c;
        }
    }
}
