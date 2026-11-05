<?php

use Doctrine\DBAL\Platforms\AbstractPlatform;

final class NullablePlatform
{
    private ?AbstractPlatform $platform = null;

    public function nullsafe(?AbstractPlatform $platform): ?string
    {
        return $platform?->getName();
    }

    public function nullableProperty(): bool
    {
        return $this->platform->getName() === 'sqlite';
    }
}

?>
-----
<?php

use Doctrine\DBAL\Platforms\AbstractPlatform;

final class NullablePlatform
{
    private ?AbstractPlatform $platform = null;

    public function nullsafe(?AbstractPlatform $platform): ?string
    {
        return $platform === null ? null : \Ibexa\Contracts\DoctrineSchema\Database\DatabasePlatformResolver::resolveName($platform)?->value;
    }

    public function nullableProperty(): bool
    {
        return ($this->platform === null ? null : \Ibexa\Contracts\DoctrineSchema\Database\DatabasePlatformResolver::resolveName($this->platform)?->value) === 'sqlite';
    }
}

?>
