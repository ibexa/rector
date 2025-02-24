<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Contracts\Rector\Tests;

use Ibexa\Contracts\Rector\Factory\IbexaRectorConfigFactory;
use Ibexa\Contracts\Rector\Sets\IbexaSetList;
use PHPUnit\Framework\TestCase;
use Rector\Config\RectorConfig;
use Rector\Configuration\Option;
use Rector\Configuration\Parameter\SimpleParameterProvider;
use Rector\Symfony\Set\SymfonySetList;

final class IbexaRectorConfigFactoryTest extends TestCase
{
    /**
     * @throws \Rector\Exception\Configuration\InvalidConfigurationException
     */
    public function testInvokeWithPaths(): void
    {
        $paths = [__DIR__, __DIR__ . '/../'];

        $factory = new IbexaRectorConfigFactory($paths);

        self::assertSame($paths, self::getRectorParameterFromFactory(Option::PATHS, $factory));
    }

    /**
     * @return iterable<string, array{string[], string[]}>
     */
    public static function getSetsForIbexaConfigFactory(): iterable
    {
        $expectedSetList = [
            SymfonySetList::SYMFONY_52_VALIDATOR_ATTRIBUTES,
            // SYMFONY_53 adds this extra set
            SymfonySetList::ANNOTATIONS_TO_ATTRIBUTES,
            IbexaSetList::IBEXA_50->value,
            SymfonySetList::SYMFONY_50,
            SymfonySetList::SYMFONY_50_TYPES,
            SymfonySetList::SYMFONY_51,
            SymfonySetList::SYMFONY_52,
            SymfonySetList::SYMFONY_53,
            SymfonySetList::SYMFONY_54,
            SymfonySetList::SYMFONY_CODE_QUALITY,
            SymfonySetList::SYMFONY_CONSTRUCTOR_INJECTION,
            SymfonySetList::SYMFONY_60,
            SymfonySetList::SYMFONY_61,
            SymfonySetList::SYMFONY_62,
            SymfonySetList::SYMFONY_63,
            SymfonySetList::SYMFONY_64,
        ];

        yield 'default set list' => [
            [],
            $expectedSetList,
        ];

        $expectedSetList[] = SymfonySetList::SYMFONY_44;
        yield 'extra set list' => [
            [
                SymfonySetList::SYMFONY_44,
            ],
            $expectedSetList,
        ];
    }

    /**
     * @dataProvider getSetsForIbexaConfigFactory
     *
     * @param string[] $extraSets
     * @param string[] $expectedSets
     *
     * @throws \Rector\Exception\Configuration\InvalidConfigurationException
     */
    public function testInvokeWithExtraSets(array $extraSets, array $expectedSets): void
    {
        $factory = new IbexaRectorConfigFactory([__DIR__], $extraSets);

        self::assertEqualsCanonicalizing($expectedSets, self::getRectorParameterFromFactory(Option::REGISTERED_RECTOR_SETS, $factory));
    }

    /**
     * @phpstan-param \Rector\Configuration\Option::* $parameterName
     *
     * @return array<mixed>
     *
     * @throws \Rector\Exception\Configuration\InvalidConfigurationException
     */
    private static function getRectorParameterFromFactory(
        string $parameterName,
        IbexaRectorConfigFactory $ibexaRectorConfigFactory
    ): array {
        $configBuilder = $ibexaRectorConfigFactory();
        $config = new RectorConfig();
        $configBuilder($config);

        // seems there's no straightforward way to get configured data without involving Rector Symfony console command
        // workaround using SimpleParameterProvider and internal Rector option (parameter) names
        return SimpleParameterProvider::provideArrayParameter($parameterName);
    }
}
