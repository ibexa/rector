<?php

use Ibexa\Bundle\RepositoryInstaller\Installer\CoreInstaller;

final class ParamUsedElsewhere extends CoreInstaller
{
    private object $schemaBuilder;

    public function __construct(object $db, object $schemaBuilder, bool $doctrineMigrationsEnabled, ?object $taggedMigrationsRunner = null)
    {
        parent::__construct($db, $schemaBuilder, $doctrineMigrationsEnabled, $taggedMigrationsRunner);

        $this->schemaBuilder = $schemaBuilder;
    }
}

?>
-----
<?php

use Ibexa\Bundle\RepositoryInstaller\Installer\CoreInstaller;

final class ParamUsedElsewhere extends CoreInstaller
{
    private object $schemaBuilder;

    public function __construct(object $db, object $schemaBuilder, ?object $taggedMigrationsRunner = null)
    {
        parent::__construct($db, $taggedMigrationsRunner);

        $this->schemaBuilder = $schemaBuilder;
    }
}

?>
