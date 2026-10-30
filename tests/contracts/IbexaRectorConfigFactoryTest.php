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
use Rector\Doctrine\Set\DoctrineSetList;
use Rector\Exception\Configuration\InvalidConfigurationException;
use Rector\Set\ValueObject\SetList;
use Rector\Symfony\Set\SymfonySetList;

/**
 * @covers \Ibexa\Contracts\Rector\Factory\IbexaRectorConfigFactory
 */
final class IbexaRectorConfigFactoryTest extends TestCase
{
    /**
     * @throws InvalidConfigurationException
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
            // SYMFONY_53 adds this extra set
            IbexaSetList::IBEXA_60->value,
            SymfonySetList::SYMFONY_50,
            SymfonySetList::SYMFONY_50_TYPES,
            SymfonySetList::SYMFONY_51,
            SymfonySetList::SYMFONY_52,
            SymfonySetList::SYMFONY_52_VALIDATOR_ATTRIBUTES,
            SymfonySetList::SYMFONY_53,
            SymfonySetList::SYMFONY_54,
            SymfonySetList::SYMFONY_CONSTRUCTOR_INJECTION,
            SymfonySetList::SYMFONY_60,
            SymfonySetList::SYMFONY_61,
            SymfonySetList::SYMFONY_62,
            SymfonySetList::SYMFONY_63,
            SymfonySetList::SYMFONY_64,
            SymfonySetList::SYMFONY_70,
            SymfonySetList::SYMFONY_71,
            SymfonySetList::SYMFONY_72,
            SetList::BEHAT_ANNOTATIONS_TO_ATTRIBUTES,
            // IBEXA_60 adds this extra set
            DoctrineSetList::COMPOSER_BASED,
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
     * @throws InvalidConfigurationException
     */
    public function testInvokeWithExtraSets(
        array $extraSets,
        array $expectedSets
    ): void {
        $factory = new IbexaRectorConfigFactory([__DIR__], $extraSets);

        self::assertEqualsCanonicalizing(
            $expectedSets,
            self::getRectorParameterFromFactory(Option::REGISTERED_RECTOR_SETS, $factory)
        );
    }

    /**
     * @phpstan-param Option::* $parameterName
     *
     * @return array<mixed>
     *
     * @throws InvalidConfigurationException
     */
    private static function getRectorParameterFromFactory(
        string $parameterName,
        IbexaRectorConfigFactory $ibexaRectorConfigFactory
    ): array {
        // unset static parameter to make tests independent
        SimpleParameterProvider::setParameter($parameterName, []);

        // the parameter gets sets again as a result of those calls
        $configBuilder = $ibexaRectorConfigFactory->createConfig();
        $config = new RectorConfig();
        $configBuilder($config);

        // seems there's no straightforward way to get configured data without involving Rector Symfony console command
        // workaround using SimpleParameterProvider and internal Rector option (parameter) names
        return SimpleParameterProvider::provideArrayParameter($parameterName);
    }
}
