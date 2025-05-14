<?php

namespace Ibexa\Rector\Tests\Rule\AddReturnTypeFromPhpDocRule\Fixture;

interface SomeInterface
{
    public function someFunction(): mixed;
}

class SomeClass implements SomeInterface
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

interface SomeInterface
{
    public function someFunction(): mixed;
}

class SomeClass implements SomeInterface
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
