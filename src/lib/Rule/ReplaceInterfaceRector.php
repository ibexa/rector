<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Rector\Rule;

use PhpParser\Node;
use PhpParser\Node\Name;
use PhpParser\Node\Stmt\Class_;
use Rector\Contract\Rector\ConfigurableRectorInterface;
use Rector\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

final class ReplaceInterfaceRector extends AbstractRector implements ConfigurableRectorInterface
{
    /** @var class-string */
    private string $interfaceToBeReplaced;

    /** @var class-string */
    private string $interfaceToReplaceWith;

    /**
     * @throws \Exception
     */
    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition('Replace OldInterface with NewInterface', [new ConfiguredCodeSample(
            <<<'CODE_SAMPLE'
                class SomeClass implements OldInterface
                {
                }
            CODE_SAMPLE,
            <<<'CODE_SAMPLE'
                class SomeClass implements NewInterface
                {
                }
            CODE_SAMPLE,
            ['var_dump']
        )]);
    }

    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes(): array
    {
        return [Class_::class];
    }

    /**
     * @param \PhpParser\Node\Stmt\Class_ $node
     */
    public function refactor(Node $node): Node
    {
        foreach ($node->implements as $key => $implement) {
            if ($this->isName($implement, $this->interfaceToBeReplaced)) {
                $node->implements[$key] = new Name($this->interfaceToReplaceWith);
            }
        }

        return $node;
    }

    public function configure(array $configuration): void
    {
        $this->interfaceToBeReplaced = $configuration['to_replace'];
        $this->interfaceToReplaceWith = $configuration['replace_with'];
    }
}
