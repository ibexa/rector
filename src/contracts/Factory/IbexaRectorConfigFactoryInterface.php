<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Contracts\Rector\Factory;

use Rector\Configuration\RectorConfigBuilder;

/**
 * Provides configuration contract to generate RectorConfigBuilder with Ibexa set configuration for internal use by Ibexa packages.
 */
interface IbexaRectorConfigFactoryInterface
{
    public function createConfig(): RectorConfigBuilder;
}
