<?php

use Doctrine\DBAL\Platforms\AbstractMySQLPlatform;

final class PlatformSubclass
{
    public function name(AbstractMySQLPlatform $platform): string
    {
        return $platform->getName();
    }
}

?>
-----
<?php

use Doctrine\DBAL\Platforms\AbstractMySQLPlatform;

final class PlatformSubclass
{
    public function name(AbstractMySQLPlatform $platform): string
    {
        return \Ibexa\Contracts\DoctrineSchema\Database\DatabasePlatformResolver::resolveName($platform)?->value;
    }
}

?>
