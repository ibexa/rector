<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Contracts\Rector\Sets;

enum IbexaSetList: string
{
    case IBEXA_50 = __DIR__ . '/ibexa-50.php';
    case SYMFONY_EXTRA = __DIR__ . '/symfony-extra.php';
}
