<?php

declare(strict_types=1);

namespace Ibexa\Rector\Rule;

use PhpParser\Node;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Param;
use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\Type\ObjectType;
use PHPStan\Type\Type;
use Rector\Exception\ShouldNotHappenException;
use Rector\PHPStanStaticTypeMapper\Enum\TypeKind;
use Rector\Rector\AbstractRector;
use Rector\StaticTypeMapper\StaticTypeMapper;

/**
 * @see \Ibexa\Rector\Tests\Rule\ChangeLimitationTypeValueObjectToObjectRector\ChangeLimitationTypeValueObjectToObjectRectorTest
 */
final class ChangeLimitationTypeValueObjectToObjectRector extends AbstractRector
{
    private const string IBEXA_LIMITATION_TYPE_INTERFACE = 'Ibexa\\Contracts\\Core\\Limitation\\Type';
    private const string IBEXA_LIMITATION_TYPE_EVALUATE_METHOD = 'evaluate';
    private const int IBEXA_LIMITATION_TYPE_EVALUATE_METHOD_POSITION = 2;

    private StaticTypeMapper $staticTypeMapper;

    public function __construct(
        StaticTypeMapper $staticTypeMapper
    ) {
        $this->staticTypeMapper = $staticTypeMapper;
    }

    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes(): array
    {
        return [
            Node\Stmt\Class_::class,
            Node\Stmt\Interface_::class
        ];
    }

    /**
     * @param \PhpParser\Node\Stmt\Class_|\PhpParser\Node\Stmt\Interface_ $node
     */
    public function refactor(Node $node): ?Node
    {
        if (!$this->isLimitationTypeClass($node)) {
            return null;
        }

        $evaluateMethod = $node->getMethod(self::IBEXA_LIMITATION_TYPE_EVALUATE_METHOD);
        if ($evaluateMethod === null) {
            return null;
        }

        if (!isset($evaluateMethod->params[self::IBEXA_LIMITATION_TYPE_EVALUATE_METHOD_POSITION])) {
            return null;
        }

        $param = $evaluateMethod->params[self::IBEXA_LIMITATION_TYPE_EVALUATE_METHOD_POSITION];
        if ($this->isObjectType($param, new ObjectType('object'))) {
            return null;
        }

        if (!isset($param->var->name)) {
            throw new ShouldNotHappenException(sprintf(
                'Method %s::%s argument should have a name',
                self::IBEXA_LIMITATION_TYPE_INTERFACE,
                self::IBEXA_LIMITATION_TYPE_EVALUATE_METHOD,
            ));
        }

        $this->addClassMethodParam(
            $evaluateMethod,
            new ObjectType('object'),
            $param->var->name,
        );

        return $node;
    }

    private function addClassMethodParam(
        ClassMethod $classMethod,
        Type $type,
        string $paramName
    ) : void {
        $param = new Param(new Variable($paramName));
        $param->type = $this->staticTypeMapper->mapPHPStanTypeToPhpParserNode($type, TypeKind::PARAM);

        $classMethod->params[self::IBEXA_LIMITATION_TYPE_EVALUATE_METHOD_POSITION] = $param;
    }

    private function isLimitationTypeClass(Node\Stmt\Class_|Node\Stmt\Interface_ $class): bool
    {
        $limitationTypeInterface = self::IBEXA_LIMITATION_TYPE_INTERFACE;
        $objectType = new ObjectType($limitationTypeInterface);

        $classType = $this->getType($class);

        return $objectType->isSuperTypeOf($classType)->yes();
    }
}
