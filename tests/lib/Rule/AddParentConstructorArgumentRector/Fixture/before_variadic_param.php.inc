<?php

use Ibexa\Core\Search\Legacy\Content\Common\Gateway\CriterionHandler;

final class VariadicParam extends CriterionHandler
{
    private array $extensions;

    public function __construct(object $connection, object ...$extensions)
    {
        parent::__construct($connection);
        $this->extensions = $extensions;
    }
}

?>
-----
<?php

use Ibexa\Core\Search\Legacy\Content\Common\Gateway\CriterionHandler;

final class VariadicParam extends CriterionHandler
{
    private array $extensions;

    public function __construct(object $connection, \Ibexa\Core\Persistence\Doctrine\JoinedTablesTracker $joinedTablesTracker, object ...$extensions)
    {
        parent::__construct($connection, $joinedTablesTracker);
        $this->extensions = $extensions;
    }
}

?>
