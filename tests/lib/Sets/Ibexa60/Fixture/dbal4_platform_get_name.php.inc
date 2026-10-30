<?php

namespace Ibexa\Rector\Tests\Sets\Ibexa60\Fixture;

use Doctrine\DBAL\Connection;

final class PlatformAwareGateway
{
    public function __construct(private readonly Connection $connection)
    {
    }

    public function isPostgreSql(): bool
    {
        return $this->connection->getDatabasePlatform()->getName() === 'postgresql';
    }
}

?>
-----
<?php

namespace Ibexa\Rector\Tests\Sets\Ibexa60\Fixture;

use Ibexa\Contracts\DoctrineSchema\Database\DatabasePlatformResolver;
use Doctrine\DBAL\Connection;

final class PlatformAwareGateway
{
    public function __construct(private readonly Connection $connection)
    {
    }

    public function isPostgreSql(): bool
    {
        return DatabasePlatformResolver::resolveName($this->connection->getDatabasePlatform())?->value === 'postgresql';
    }
}

?>
