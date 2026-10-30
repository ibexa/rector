<?php

use Doctrine\DBAL\Connection;

final class ConnectionPlatform
{
    public function isMySql(Connection $connection): bool
    {
        return $connection->getDatabasePlatform()->getName() === 'mysql';
    }
}

?>
-----
<?php

use Doctrine\DBAL\Connection;

final class ConnectionPlatform
{
    public function isMySql(Connection $connection): bool
    {
        return \Ibexa\Contracts\DoctrineSchema\Database\DatabasePlatformResolver::resolveName($connection->getDatabasePlatform())?->value === 'mysql';
    }
}

?>
