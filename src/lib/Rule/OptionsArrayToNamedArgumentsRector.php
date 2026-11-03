<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Rector\Rule;

use Ibexa\Rector\Rule\Configuration\OptionsArrayToNamedArgumentsConfiguration;
use Ibexa\Rector\Tests\Rule\OptionsArrayToNamedArgumentsRector\OptionsArrayToNamedArgumentsRectorTest;
use InvalidArgumentException;
use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\ArrayItem;
use PhpParser\Node\Attribute;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\ClassConstFetch;
use PhpParser\Node\Expr\ConstFetch;
use PhpParser\Node\Expr\New_;
use PhpParser\Node\Identifier;
use PhpParser\Node\Scalar;
use PhpParser\Node\Scalar\String_;
use PHPStan\Reflection\ReflectionProvider;
use Rector\Contract\Rector\ConfigurableRectorInterface;
use Rector\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

/**
 * Converts the options array of a constructor that now takes named arguments, e.g. Ibexa validation constraints
 * on Symfony 8, which the stock ConstraintOptionsToNamedArgumentsRector skips as it only covers Symfony's own.
 *
 * Calls it can't convert safely (a non-literal options array, keys the new constructor doesn't take) are left alone.
 *
 * @see OptionsArrayToNamedArgumentsRectorTest
 */
final class OptionsArrayToNamedArgumentsRector extends AbstractRector implements ConfigurableRectorInterface
{
    private const string OPTIONS = 'options';

    /** @var array<string, OptionsArrayToNamedArgumentsConfiguration> */
    private array $configurations = [];

    public function __construct(
        private readonly ReflectionProvider $reflectionProvider,
    ) {}

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'Replace the options array of a constructor that now takes named arguments',
            [
                new ConfiguredCodeSample(
                    "new ProductPriceCurrency(\$cart, ['message' => 'Wrong currency']);",
                    "new ProductPriceCurrency(\$cart, message: 'Wrong currency');",
                    [
                        new OptionsArrayToNamedArgumentsConfiguration(
                            'Ibexa\Cart\Validation\Constraint\ProductPriceCurrency',
                            ['cart', 'message', 'groups', 'payload'],
                            ['cart', 'options', 'message', 'groups', 'payload'],
                        ),
                    ]
                ),
            ]
        );
    }

    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes(): array
    {
        return [New_::class, Attribute::class];
    }

    /**
     * @param New_|Attribute $node
     */
    public function refactor(Node $node): ?Node
    {
        if ($node instanceof New_ && $node->isFirstClassCallable()) {
            return null;
        }

        $className = $this->getName($node instanceof New_ ? $node->class : $node->name);
        $configuration = $className === null ? null : $this->findConfiguration($className);
        if ($configuration === null) {
            return null;
        }

        $args = $this->convertArgs($node->args, $configuration);
        if ($args === null) {
            return null;
        }

        $node->args = $args;

        return $node;
    }

    public function configure(array $configuration): void
    {
        foreach ($configuration as $c) {
            if (!$c instanceof OptionsArrayToNamedArgumentsConfiguration) {
                throw new InvalidArgumentException(sprintf(
                    '%s expects a list of %s, got %s',
                    self::class,
                    OptionsArrayToNamedArgumentsConfiguration::class,
                    get_debug_type($c),
                ));
            }

            $this->configurations[$c->getClass()] = $c;
        }
    }

    /**
     * A subclass is converted only when it inherits the constructor, its own constructor takes its own arguments.
     */
    private function findConfiguration(string $className): ?OptionsArrayToNamedArgumentsConfiguration
    {
        if (isset($this->configurations[$className])) {
            return $this->configurations[$className];
        }

        if (!$this->reflectionProvider->hasClass($className)) {
            return null;
        }

        $classReflection = $this->reflectionProvider->getClass($className);
        if (!$classReflection->hasConstructor()) {
            return null;
        }

        $constructorClass = $classReflection->getConstructor()->getDeclaringClass();
        foreach ($this->configurations as $class => $configuration) {
            if ($classReflection->isSubclassOf($class)
                && !$constructorClass->isSubclassOf($class)
            ) {
                return $configuration;
            }
        }

        return null;
    }

    /**
     * @param array<Arg|Node\VariadicPlaceholder> $args
     *
     * @return list<Arg>|null
     */
    private function convertArgs(
        array $args,
        OptionsArrayToNamedArgumentsConfiguration $configuration
    ): ?array {
        $previousParameters = $configuration->getPreviousParameters();

        /** @var array<string, Expr> $values */
        $values = [];
        /** @var array<string, true> $positional */
        $positional = [];
        $options = null;
        foreach (array_values($args) as $position => $arg) {
            if (!$arg instanceof Arg || $arg->unpack || $arg->byRef) {
                return null;
            }

            $name = $arg->name?->toString() ?? $previousParameters[$position] ?? null;
            if ($name === null || isset($values[$name]) || ($name === self::OPTIONS && $options !== null)) {
                return null;
            }

            if ($name === self::OPTIONS) {
                $options = $arg;
                continue;
            }

            $values[$name] = $arg->value;
            if ($arg->name === null) {
                $positional[$name] = true;
            }
        }

        if ($options === null) {
            return null;
        }

        $optionValues = $this->resolveOptionValues($options, $configuration);
        if ($optionValues === null) {
            return null;
        }

        foreach ($optionValues as $name => $value) {
            if (isset($values[$name])) {
                return null;
            }

            $values[$name] = $value;
        }

        if (array_diff(array_keys($values), $configuration->getParameters()) !== []) {
            return null;
        }

        // arguments keep their position as long as every earlier parameter is passed positionally too
        $newArgs = [];
        $keepPosition = true;
        foreach ($configuration->getParameters() as $index => $parameter) {
            if (!isset($values[$parameter])) {
                $keepPosition = false;
                continue;
            }

            $keepPosition = $keepPosition && isset($positional[$parameter]) && $index === count($newArgs);
            $newArgs[] = new Arg($values[$parameter], name: $keepPosition ? null : new Identifier($parameter));
        }

        return $newArgs;
    }

    /**
     * @return array<string, Expr>|null
     */
    private function resolveOptionValues(
        Arg $options,
        OptionsArrayToNamedArgumentsConfiguration $configuration
    ): ?array {
        $value = $options->value;
        if ($value instanceof ConstFetch && $this->isName($value, 'null')) {
            return [];
        }

        if (!$value instanceof Array_ || !$this->hasStringKeys($value)) {
            // a literal list or scalar was the value of the default option, anything else may be an options array
            $defaultOption = $configuration->getDefaultOption();
            $isLiteral = $value instanceof Array_ || $value instanceof Scalar
                || $value instanceof ConstFetch || $value instanceof ClassConstFetch;

            return $defaultOption === null || !$isLiteral ? null : [$defaultOption => $value];
        }

        $values = [];
        foreach ($value->items as $item) {
            if (!$item instanceof ArrayItem || !$item->key instanceof String_) {
                return null;
            }

            // the groups parameter is an array, a single group was accepted as a string
            $values[$item->key->value] = $item->key->value === 'groups' && !$item->value instanceof Array_
                ? new Array_([new ArrayItem($item->value)])
                : $item->value;
        }

        return $values;
    }

    private function hasStringKeys(Array_ $array): bool
    {
        foreach ($array->items as $item) {
            if ($item instanceof ArrayItem && $item->key instanceof String_) {
                return true;
            }
        }

        return false;
    }
}
