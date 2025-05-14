<?php

namespace Ibexa\Rector\Tests\Rule\AddReturnTypeFromParentMethodRule\Fixture;

abstract class SomeMiddleAbstract extends SomeAbstract
{
}

abstract class SomeAbstract
{
    abstract public function someFunction(): mixed;
}

class SomeClass extends SomeMiddleAbstract
{
    public function someFunction()
    {
        return new SomeObject();
    }
}

class SomeObject
{
}

?>
-----
<?php

namespace Ibexa\Rector\Tests\Rule\AddReturnTypeFromParentMethodRule\Fixture;

abstract class SomeMiddleAbstract extends SomeAbstract
{
}

abstract class SomeAbstract
{
    abstract public function someFunction(): mixed;
}

class SomeClass extends SomeMiddleAbstract
{
    public function someFunction(): mixed
    {
        return new SomeObject();
    }
}

class SomeObject
{
}

?>
