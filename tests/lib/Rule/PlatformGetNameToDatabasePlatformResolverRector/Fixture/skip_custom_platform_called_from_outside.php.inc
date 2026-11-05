<?php

use Doctrine\DBAL\Platforms\AbstractPlatform;

final class OwnNamePlatform extends AbstractPlatform
{
    public function getName(): string
    {
        return 'custom';
    }
}

final class OwnNamePlatformUser
{
    public function name(OwnNamePlatform $platform): string
    {
        return $platform->getName();
    }
}

?>
