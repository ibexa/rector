<?php /** @noinspection ALL */

namespace Ibexa\Rector\Tests\Rule\ConstToEnumValueRector\Fixture;

enum SomeEnum: int
{
    case FOO = 1;
    case BAZ = 2;
}

class SomeClass
{
    public const int FOO = 1;
    public const int BAR = 2;

    public function someMethod(): int
    {
        return SomeClass::FOO | SomeClass::BAR;
    }
}

?>
-----
<?php /** @noinspection ALL */

namespace Ibexa\Rector\Tests\Rule\ConstToEnumValueRector\Fixture;

enum SomeEnum: int
{
    case FOO = 1;
    case BAZ = 2;
}

class SomeClass
{
    public const int FOO = 1;
    public const int BAR = 2;

    public function someMethod(): int
    {
        return \Ibexa\Rector\Tests\Rule\ConstToEnumValueRector\Fixture\EnumClass::FOO->value | \Ibexa\Rector\Tests\Rule\ConstToEnumValueRector\Fixture\EnumClass::BAZ->value;
    }
}

?>
