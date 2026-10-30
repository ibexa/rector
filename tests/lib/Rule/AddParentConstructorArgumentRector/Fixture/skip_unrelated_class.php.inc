<?php

abstract class SomeBase
{
    public function __construct(object $connection)
    {
    }
}

final class Unrelated extends SomeBase
{
    public function __construct(object $connection)
    {
        parent::__construct($connection);
    }
}

?>
