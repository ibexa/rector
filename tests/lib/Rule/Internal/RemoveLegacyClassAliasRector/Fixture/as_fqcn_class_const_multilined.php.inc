<?php /** @noinspection ALL */

namespace Ibexa\Rector\Tests\Rule\Internal\RemoveLegacyClassAliasRector\Fixture;

class MyYetAnotherLegacyClass
{
    public function foo(): void
    {
    }
}

class_alias(
        MyYetAnotherLegacyClass::class,
        \EzSystems\Some\Namespace\MyYetAnotherLegacyClass::class
);

?>
-----
<?php /** @noinspection ALL */

namespace Ibexa\Rector\Tests\Rule\Internal\RemoveLegacyClassAliasRector\Fixture;

class MyYetAnotherLegacyClass
{
    public function foo(): void
    {
    }
}

?>
