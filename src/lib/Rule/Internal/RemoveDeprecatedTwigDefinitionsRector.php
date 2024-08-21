<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Rector\Rule\Internal;

use PhpParser\Node;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\ArrayItem;
use PhpParser\Node\Expr\New_;
use PhpParser\Node\Stmt\ClassMethod;
use Rector\Contract\Rector\ConfigurableRectorInterface;
use Rector\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use Twig\TwigFilter;
use Twig\TwigFunction;

/**
 * @internal This rule is internal, for Ibexa 1st party packages
 */
final class RemoveDeprecatedTwigDefinitionsRector extends AbstractRector implements ConfigurableRectorInterface
{
    /** @var string|int|true */
    private $version;

    /**
     * @throws \Exception
     */
    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition('Remove legacy eZ Systems & Ibexa class_alias calls', [new ConfiguredCodeSample(
            <<<'CODE_SAMPLE'
    public function getFunctions(): array
    {
        return [
            new TwigFunction(
                'old_function_name',
                null,
                [
                    'is_safe' => ['html'],
                    'needs_environment' => true,
                    'deprecated' => '4.0',
                    'alternative' => 'new_function_name',
                ]
            ),
            new TwigFunction(
                'new_function_name',
                null,
                [
                    'is_safe' => ['html'],
                    'needs_environment' => true,
                ]
            ),
        ];
    }
CODE_SAMPLE
            ,
            <<<'CODE_SAMPLE'
    public function getFunctions(): array
    {
        return [
            new TwigFunction(
                'new_function_name',
                null,
                [
                    'is_safe' => ['html'],
                    'needs_environment' => true,
                ]
            ),
        ];
    }
CODE_SAMPLE
            ,
            ['var_dump']
        )]);
    }

    public function getNodeTypes(): array
    {
        return [ClassMethod::class];
    }

    public function refactor(Node $node): ?Node
    {
        // Ensure the method is named "getFunctions"
        if (!$node instanceof ClassMethod
            || (
                !$this->isName($node, 'getFunctions')
                && !$this->isName($node, 'getFilters')
            )
        ) {
            return null;
        }

        // Look for the return statement within the method
        foreach ($node->stmts as $stmt) {
            if ($stmt instanceof Node\Stmt\Return_ && $stmt->expr instanceof Array_) {
                $arrayNode = $stmt->expr;

                // Filter out TwigFunction declarations with the 'deprecated' option
                $arrayNode->items = array_filter($arrayNode->items, function (?ArrayItem $item) {
                    if ($item === null || !$item->value instanceof New_) {
                        return true;
                    }

                    /** @var \PhpParser\Node\Expr\New_ $newExpr */
                    $newExpr = $item->value;

                    // Ensure it's a 'Twig\TwigFunction' instantiation
                    if (!$newExpr->class instanceof Node\Name
                        || (!$this->isName($newExpr->class, TwigFunction::class)
                         && !$this->isName($newExpr->class, TwigFilter::class))
                    ) {
                        return true;
                    }

                    // Check if the third argument (options array) contains the 'deprecated' key
                    if (isset($newExpr->args[2]) && $newExpr->args[2]->value instanceof Array_) {
                        $optionsArray = $newExpr->args[2]->value;

                        foreach ($optionsArray->items as $optionItem) {
                            if ($optionItem instanceof ArrayItem &&
                                $optionItem->key instanceof Node\Scalar\String_ &&
                                $optionItem->key->value === 'deprecated' &&
                                $optionItem->value->value === $this->version
                            ) {
                                // Skip this item if 'deprecated' is found
                                return false;
                            }
                        }
                    }

                    return true;
                });
            }
        }

        return $node;
    }

    public function configure(array $configuration): void
    {
        $this->version = $configuration['version'] ?? true;
    }
}
