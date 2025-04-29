<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Rector\Rule;

use PhpParser\Node;
use PhpParser\Node\Expr\ClassConstFetch;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Name\FullyQualified;
use Rector\Contract\Rector\ConfigurableRectorInterface;
use Rector\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

final class ConstToEnumValueRector extends AbstractRector implements ConfigurableRectorInterface
{
    /**
     * @var array<string, array{enumClass: string, constants: array<string>|null}>
     */
    private array $transformationMap = [];

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'Replace class constants with enum values (adds ->value)',
            [
                new ConfiguredCodeSample(
                    'OldClass::CONSTANT',
                    'EnumClass::CONSTANT->value',
                    [
                        'Old\Namespace\OldClass' => [
                            'enumClass' => 'New\Namespace\EnumClass',
                            'constants' => [
                                'OLD_NAME' => 'NEW_NAME',
                                'SAME_NAME' => 'SAME_NAME',
                            ],
                        ],
                    ]
                ),
            ]
        );
    }

    public function configure(array $configuration): void
    {
        foreach ($configuration as $oldClass => $config) {
            $this->transformationMap[$oldClass] = [
                'enumClass' => $config['enumClass'],
                'constants' => $config['constants'],
            ];
        }
    }

    public function getNodeTypes(): array
    {
        return [ClassConstFetch::class];
    }

    /**
     * @param \PhpParser\Node\Expr\ClassConstFetch $node
     */
    public function refactor(Node $node): ?PropertyFetch
    {
        $className = $this->getName($node->class);
        if ($className === null || !isset($this->transformationMap[$className])) {
            return null;
        }

        $constantName = $this->getName($node->name);
        if ($constantName === null) {
            return null;
        }

        $transformation = $this->transformationMap[$className];

        // Check if this constant is in our mapping
        if (!isset($transformation['constants'][$constantName])) {
            return null;
        }

        // Get the mapped constant name (might be the same or different)
        $newConstantName = $transformation['constants'][$constantName];

        // Create the enum reference: EnumClass::NEW_CONSTANT
        $enumRef = new ClassConstFetch(
            new FullyQualified($transformation['enumClass']),
            $newConstantName
        );

        // Add the ->value property fetch
        return new PropertyFetch($enumRef, 'value');
    }
}
