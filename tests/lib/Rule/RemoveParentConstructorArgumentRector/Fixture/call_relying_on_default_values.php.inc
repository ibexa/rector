<?php

use Ibexa\Bundle\RepositoryInstaller\Installer\CoreInstaller;

final class CallRelyingOnDefaultValues extends CoreInstaller
{
    public function __construct(object $db, object $schemaBuilder)
    {
        parent::__construct($db, $schemaBuilder, false);
    }
}

?>
-----
<?php

use Ibexa\Bundle\RepositoryInstaller\Installer\CoreInstaller;

final class CallRelyingOnDefaultValues extends CoreInstaller
{
    public function __construct(object $db)
    {
        parent::__construct($db);
    }
}

?>
