<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Rector\Tests\Rule\OptionsArrayToNamedArgumentsRector;

use Ibexa\Rector\Rule\OptionsArrayToNamedArgumentsRector;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class OptionsArrayToNamedArgumentsRectorConfigurationTest extends TestCase
{
    public function testRejectsEntriesOtherThanConfigurationObjects(): void
    {
        $rector = (new \ReflectionClass(OptionsArrayToNamedArgumentsRector::class))->newInstanceWithoutConstructor();

        $this->expectException(InvalidArgumentException::class);
        $rector->configure([['class' => 'Foo', 'parameters' => ['message']]]);
    }
}
