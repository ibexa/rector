<?php /** @noinspection ALL */

namespace Ibexa\Rector\Tests\Rule\Internal\RemoveLegacyClassAliasRector\Fixture;

class MyLegacyClass
{
    public function foo(): void
    {
    }
}

class_alias(MyLegacyClass::class, 'EzSystems\Some\Namespace\MyLegacyClass');

?>
-----
<?php /** @noinspection ALL */

namespace Ibexa\Rector\Tests\Rule\Internal\RemoveLegacyClassAliasRector\Fixture;

class MyLegacyClass
{
    public function foo(): void
    {
    }
}

?>
