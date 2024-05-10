<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Rector\Tests\Composer\Command\CustomRule;

use Ibexa\Rector\Composer\Command\CustomRule\RectorTemplatePathProcessor;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Finder\SplFileInfo;

/**
 * @covers \Ibexa\Rector\Composer\Command\CustomRule\RectorTemplatePathProcessor
 */
final class RectorTemplatePathProcessorTest extends TestCase
{
    /**
     * @dataProvider getDataForTestProcessPathName
     */
    public function testProcessPathName(string $ruleName, string $templateRelativePath, string $expectedName): void
    {
        $pathNameResolver = new RectorTemplatePathProcessor();

        self::assertSame(
            $expectedName,
            $pathNameResolver->processPathName(
                $ruleName,
                $this->createSymfonySplFileInfoMock($templateRelativePath)
            )
        );
    }

    /**
     * @return iterable<string, array{string, string, string}>
     */
    public static function getDataForTestProcessPathName(): iterable
    {
        $ruleName = 'Foo/Bar';

        yield 'rector implementation class' => [
            $ruleName,
            'src/Rector/__Name__.php',
            'src/lib/Rule/Foo/BarRector.php',
        ];

        yield 'rector test class' => [
            $ruleName,
            'tests/Rector/__Name__/__Name__Test.php',
            'tests/lib/Rule/Foo/BarRector/BarRectorTest.php',
        ];

        yield 'rector test fixture' => [
            $ruleName,
            'tests/Rector/__Name__/Fixture/some_class.php.inc',
            'tests/lib/Rule/Foo/BarRector/Fixture/some_class.php.inc',
        ];

        yield 'rector test rule config' => [
            $ruleName,
            'tests/Rector/__Name__/config/configured_rule.php',
            'tests/lib/Rule/Foo/BarRector/config/configured_rule.php',
        ];
    }

    private function createSymfonySplFileInfoMock(string $relativePathName): SplFileInfo
    {
        $splFileInfoMock = $this->createMock(SplFileInfo::class);
        $splFileInfoMock->method('getRelativePathname')->willReturn($relativePathName);

        return $splFileInfoMock;
    }
}
