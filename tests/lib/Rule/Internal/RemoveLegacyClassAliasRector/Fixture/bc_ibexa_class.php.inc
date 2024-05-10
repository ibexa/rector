<?php /** @noinspection ALL */

namespace Ibexa\Rector\Tests\Rule\Internal\RemoveLegacyClassAliasRector\Fixture;

class MyIbexaClass
{
    public function foo(): void
    {
    }
}

class_alias(MyIbexaClass::class, 'Ibexa\Platform\MyAnotherLegacyClass');

?>
-----
<?php /** @noinspection ALL */

namespace Ibexa\Rector\Tests\Rule\Internal\RemoveLegacyClassAliasRector\Fixture;

class MyIbexaClass
{
    public function foo(): void
    {
    }
}

?>
