<?php

final class SkipOtherGetName
{
    public function name(\ReflectionClass $class, \Doctrine\DBAL\Connection $connection): string
    {
        return $class->getName();
    }
}

?>
