<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Rector\Rule\Configuration;

final readonly class OptionsArrayToNamedArgumentsConfiguration
{
    /**
     * @param list<string> $parameters constructor parameters after the change, in order
     * @param list<string> $previousParameters constructor parameters before the change, 'options' being the options array;
     *                                         the default is Symfony's Constraint constructor
     * @param string|null $defaultOption option a non-array 'options' value was assigned to
     */
    public function __construct(
        private string $class,
        private array $parameters,
        private array $previousParameters = ['options', 'groups', 'payload'],
        private ?string $defaultOption = null,
    ) {}

    public function getClass(): string
    {
        return $this->class;
    }

    /**
     * @return list<string>
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    /**
     * @return list<string>
     */
    public function getPreviousParameters(): array
    {
        return $this->previousParameters;
    }

    public function getDefaultOption(): ?string
    {
        return $this->defaultOption;
    }
}
