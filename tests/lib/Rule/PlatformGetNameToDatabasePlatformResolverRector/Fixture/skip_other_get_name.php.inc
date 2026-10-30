<?php

final class SkipOtherGetName
{
    public function name(\ReflectionClass $class): string
    {
        return $class->getName();
    }
}

?>
