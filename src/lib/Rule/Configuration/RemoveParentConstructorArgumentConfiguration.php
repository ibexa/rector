<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Rector\Rule\Configuration;

final readonly class RemoveParentConstructorArgumentConfiguration
{
    public function __construct(
        private string $parentClass,
        private int $position,
        private string $argumentName,
    ) {}

    public function getParentClass(): string
    {
        return $this->parentClass;
    }

    public function getPosition(): int
    {
        return $this->position;
    }

    public function getArgumentName(): string
    {
        return $this->argumentName;
    }
}
