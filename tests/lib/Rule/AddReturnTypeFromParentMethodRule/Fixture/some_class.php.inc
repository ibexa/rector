<?php

namespace Ibexa\Rector\Tests\Rule\AddReturnTypeFromParentMethodRule\Fixture;

interface SomeInterface
{
    public function someFunction(): SomeObject;
}

class SomeClass implements SomeInterface
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

interface SomeInterface
{
    public function someFunction(): SomeObject;
}

class SomeClass implements SomeInterface
{
    public function someFunction(): Ibexa\Rector\Tests\Rule\AddReturnTypeFromParentMethodRule\Fixture\SomeObject
    {
        return new SomeObject();
    }
}

class SomeObject
{
}

?>
