<?php

use Doctrine\DBAL\Connection;

final class NullableCallChain
{
    public function isMySql(?Connection $connection): bool
    {
        return $connection?->getDatabasePlatform()->getName() === 'mysql';
    }
}

?>
