<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Rector\Tests\Sets;

use PHPUnit\Framework\Attributes\DataProvider;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;

abstract class AbstractIbexaRectorSetTestCase extends AbstractRectorTestCase
{
    abstract protected static function getCurrentDirectory(): string;

    #[DataProvider('provideData')]
    public function test(string $filePath): void
    {
        $this->doTestFile($filePath);
    }

    public static function provideData(): \Iterator
    {
        return self::yieldFilesFromDirectory(static::getCurrentDirectory() . '/Fixture');
    }

    public function provideConfigFilePath(): string
    {
        return static::getCurrentDirectory() . '/config/configured_rule.php';
    }
}
