<?php

namespace Ibexa\Rector\Tests\Rule\AddReturnTypeFromPhpDocRule\Fixture;

abstract Class SomeAbstract
{
    public function someFunction(): mixed;
}

class SomeClass extends SomeAbstract
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

abstract Class SomeAbstract
{
    public function someFunction(): mixed;
}

class SomeClass extends SomeAbstract
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
