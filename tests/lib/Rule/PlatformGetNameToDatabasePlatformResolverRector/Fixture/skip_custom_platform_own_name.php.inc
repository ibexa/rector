<?php

use Doctrine\DBAL\Platforms\AbstractPlatform;

final class CustomPlatform extends AbstractPlatform
{
    public function getName(): string
    {
        return 'custom';
    }

    public function describe(): string
    {
        return 'Platform ' . $this->getName();
    }
}

?>
