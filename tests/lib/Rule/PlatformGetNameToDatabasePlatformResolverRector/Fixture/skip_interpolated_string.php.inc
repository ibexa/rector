<?php

use Doctrine\DBAL\Platforms\AbstractPlatform;

final class InterpolatedString
{
    public function fail(AbstractPlatform $platform): never
    {
        throw new \RuntimeException("Unsupported platform {$platform->getName()}");
    }

    public function heredoc(AbstractPlatform $platform): string
    {
        return <<<TXT
            Platform: {$platform->getName()}
            TXT;
    }
}

?>
