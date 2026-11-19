<?php

use Ibexa\Bundle\RepositoryInstaller\Installer\CoreInstaller;

final class PromotedParam extends CoreInstaller
{
    public function __construct(object $db, private readonly object $schemaBuilder, bool $doctrineMigrationsEnabled)
    {
        parent::__construct($db, $schemaBuilder, $doctrineMigrationsEnabled);
    }
}

?>
-----
<?php

use Ibexa\Bundle\RepositoryInstaller\Installer\CoreInstaller;

final class PromotedParam extends CoreInstaller
{
    public function __construct(object $db, private readonly object $schemaBuilder)
    {
        parent::__construct($db);
    }
}

?>
