<?php

use Ibexa\Core\Search\Legacy\Content\Common\Gateway\CriterionHandler;

final class WithoutParentCall extends CriterionHandler
{
    public function __construct(private readonly object $connection)
    {
    }
}

?>
