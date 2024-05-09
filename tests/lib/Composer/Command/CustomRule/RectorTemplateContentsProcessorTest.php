<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Rector\Tests\Composer\Command\CustomRule;

use Ibexa\Rector\Composer\Command\CustomRule\RectorTemplateContentsProcessor;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Finder\SplFileInfo;

/**
 * @covers \Ibexa\Rector\Composer\Command\CustomRule\RectorTemplateContentsProcessor
 */
final class RectorTemplateContentsProcessorTest extends TestCase
{
    /**
     * @dataProvider getDataForTestProcessTemplateContents
     */
    public function testProcessTemplateContents(
        string $ruleName,
        string $templateContents,
        string $expectedContents
    ): void {
        $pathNameResolver = new RectorTemplateContentsProcessor();

        self::assertSame(
            $expectedContents,
            $pathNameResolver->processTemplateContents(
                $ruleName,
                $this->createSymfonySplFileInfoMock($templateContents)
            )
        );
    }

    /**
     * @return iterable<string, array{string, string, string}>
     */
    public static function getDataForTestProcessTemplateContents(): iterable
    {
        yield 'class of rule with namespace' => [
            'Foo/Bar/Baz',
            <<<PHP
            namespace Utils\Rector\Rector;

            final class __Name__ extends AbstractRector
            PHP,
            <<<PHP
            namespace Ibexa\Rector\Rule\Foo\Bar;

            final class BazRector extends AbstractRector
            PHP,
        ];

        yield 'class of rule without namespace' => [
            'Foo',
            <<<PHP
            namespace Utils\Rector\Rector;

            final class __Name__ extends AbstractRector
            PHP,
            <<<PHP
            namespace Ibexa\Rector\Rule;

            final class FooRector extends AbstractRector
            PHP,
        ];

        yield 'test class of rule with namespace' => [
            'Foo/Bar/Baz',
            <<<PHP
            namespace Utils\Rector\Tests\Rector;

            final class __Name__ extends AbstractRector
            PHP,
            <<<PHP
            namespace Ibexa\Rector\Tests\Rule\Foo\Bar;

            final class BazRector extends AbstractRector
            PHP,
        ];
    }

    private function createSymfonySplFileInfoMock(string $fileContents): SplFileInfo
    {
        $splFileInfoMock = $this->createMock(SplFileInfo::class);
        $splFileInfoMock->method('getContents')->willReturn($fileContents);

        return $splFileInfoMock;
    }
}
