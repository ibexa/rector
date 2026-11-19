<?php

use Ibexa\Bundle\RepositoryInstaller\Installer\CoreInstaller;

final class InstallerWithUnpackedArguments extends CoreInstaller
{
    public function __construct(mixed ...$args)
    {
        parent::__construct(...$args);
    }
}

?>
