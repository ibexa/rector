<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Contracts\Rector\Factory;

use Ibexa\Contracts\Rector\Sets\IbexaSetList;
use Rector\Config\RectorConfig;
use Rector\Configuration\RectorConfigBuilder;
use Rector\Symfony\Set\SymfonySetList;

final readonly class IbexaRectorConfigFactory implements IbexaRectorConfigFactoryInterface
{
    /**
     * @phpstan-param string[] $pathsToProcess a list of package source code directories
     * @phpstan-param string[] $extraSets extra sets to be appended to the default list of sets.
     * If you need a custom set list, excluding defaults, use regular rector.php generated by Rector PHP package instead.
     */
    public function __construct(private array $pathsToProcess, private array $extraSets = [])
    {
    }

    public function __invoke(): RectorConfigBuilder
    {
        return RectorConfig::configure()
                           ->withPaths($this->pathsToProcess)
                           ->withSets(
                               array_merge(
                                   [
                                       IbexaSetList::IBEXA_50->value,
                                       SymfonySetList::SYMFONY_50,
                                       SymfonySetList::SYMFONY_50_TYPES,
                                       SymfonySetList::SYMFONY_51,
                                       SymfonySetList::SYMFONY_52,
                                       SymfonySetList::SYMFONY_52_VALIDATOR_ATTRIBUTES,
                                       SymfonySetList::SYMFONY_53,
                                       SymfonySetList::SYMFONY_54,
                                       SymfonySetList::SYMFONY_CODE_QUALITY,
                                       SymfonySetList::SYMFONY_CONSTRUCTOR_INJECTION,
                                       SymfonySetList::SYMFONY_60,
                                       SymfonySetList::SYMFONY_61,
                                       SymfonySetList::SYMFONY_62,
                                       SymfonySetList::SYMFONY_63,
                                       SymfonySetList::SYMFONY_64,
                                   ],
                                   $this->extraSets
                               )
                           )
        ;
    }
}
