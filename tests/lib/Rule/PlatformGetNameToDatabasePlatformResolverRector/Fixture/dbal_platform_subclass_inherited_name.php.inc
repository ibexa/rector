<?php

use Doctrine\DBAL\Platforms\AbstractMySQLPlatform;

final class TunedMySQLPlatform extends AbstractMySQLPlatform
{
    public function describe(): string
    {
        return 'Platform: ' . $this->getName();
    }
}

?>
-----
<?php

use Doctrine\DBAL\Platforms\AbstractMySQLPlatform;

final class TunedMySQLPlatform extends AbstractMySQLPlatform
{
    public function describe(): string
    {
        return 'Platform: ' . \Ibexa\Contracts\DoctrineSchema\Database\DatabasePlatformResolver::resolveName($this)?->value;
    }
}

?>
