<?php

namespace Doctrine\DBAL;

use Doctrine\DBAL\Platforms\AbstractPlatform;

class Connection
{
    public function getDatabasePlatform(): AbstractPlatform
    {
        throw new \LogicException('Stub');
    }
}
