<?php

use Ibexa\Core\Search\Legacy\Content\Common\Gateway\CriterionHandler;

final class UnpackedArguments extends CriterionHandler
{
    public function __construct(object ...$args)
    {
        parent::__construct(...$args);
    }
}

?>
