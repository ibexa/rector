<?php

namespace Ibexa\Rector\Tests\Rule\AddReturnTypeFromPhpDocRule\Fixture;

abstract class SomeMiddleAbstract extends SomeAbstract
{
}

abstract class SomeAbstract
{
    public function someFunction(): mixed;
}

class SomeClass extends SomeMiddleAbstract
{
    /** @return SomeObject */
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

namespace Ibexa\Rector\Tests\Rule\AddReturnTypeFromPhpDocRule\Fixture;

abstract class SomeMiddleAbstract extends SomeAbstract
{
}

abstract class SomeAbstract
{
    public function someFunction(): mixed;
}

class SomeClass extends SomeMiddleAbstract
{
    /** @return SomeObject */
    public function someFunction(): \Ibexa\Rector\Tests\Rule\AddReturnTypeFromPhpDocRule\Fixture\SomeObject
    {
        return new SomeObject();
    }
}

class SomeObject
{
}

?>
