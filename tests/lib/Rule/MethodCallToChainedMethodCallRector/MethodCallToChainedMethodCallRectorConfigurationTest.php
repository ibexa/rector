<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Rector\Tests\Rule\MethodCallToChainedMethodCallRector;

use Ibexa\Rector\Rule\MethodCallToChainedMethodCallRector;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class MethodCallToChainedMethodCallRectorConfigurationTest extends TestCase
{
    public function testRejectsEntriesOtherThanConfigurationObjects(): void
    {
        $rector = new MethodCallToChainedMethodCallRector();

        $this->expectException(InvalidArgumentException::class);
        $rector->configure([['type' => 'Foo', 'oldMethod' => 'getId']]);
    }
}
