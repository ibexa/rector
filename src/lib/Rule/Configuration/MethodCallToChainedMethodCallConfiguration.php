<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Rector\Rule\Configuration;

final readonly class MethodCallToChainedMethodCallConfiguration
{
    /**
     * @param non-empty-list<string> $newMethods
     */
    public function __construct(
        private string $type,
        private string $oldMethod,
        private array $newMethods,
    ) {}

    public function getType(): string
    {
        return $this->type;
    }

    public function getOldMethod(): string
    {
        return $this->oldMethod;
    }

    /**
     * @return non-empty-list<string>
     */
    public function getNewMethods(): array
    {
        return $this->newMethods;
    }
}
