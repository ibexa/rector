<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Rector\Rule\Configuration;

final readonly class ChangeArgumentTypeConfiguration
{
    public function __construct(
        private string $interface,
        private string $method,
        private int $argumentPosition,
        private string $argumentClassName,
        private ?string $newArgumentClass = null,
    ) {
    }

    public function getInterface(): string
    {
        return $this->interface;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getArgumentPosition(): int
    {
        return $this->argumentPosition;
    }

    public function getArgumentClassName(): string
    {
        return $this->argumentClassName;
    }

    public function getNewArgumentClass(): ?string
    {
        return $this->newArgumentClass;
    }
}
