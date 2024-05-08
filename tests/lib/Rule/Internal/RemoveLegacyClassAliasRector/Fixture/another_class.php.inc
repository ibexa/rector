<?php /** @noinspection ALL */

namespace Ibexa\Rector\Tests\Rule\Internal\RemoveLegacyClassAliasRector\Fixture;

class MyAnotherLegacyClass
{
    public function foo(): void
    {
    }
}

class_alias(MyAnotherLegacyClass::class, 'eZ\Some\Namespace\MyAnotherLegacyClass');

?>
-----
<?php /** @noinspection ALL */

namespace Ibexa\Rector\Tests\Rule\Internal\RemoveLegacyClassAliasRector\Fixture;

class MyAnotherLegacyClass
{
    public function foo(): void
    {
    }
}

?>
