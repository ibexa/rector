<?php /** @noinspection ALL */

namespace Ibexa\Rector\Tests\Rule\Internal\RemoveLegacyClassAliasRector\Fixture;

class MySpecTestCase
{
    public function foo(): void
    {
    }
}

class_alias(
    MySpecTestCase::class,
    'spec\EzSystems\Some\Namespace\MySpecTestCase'
);

?>
-----
<?php /** @noinspection ALL */

namespace Ibexa\Rector\Tests\Rule\Internal\RemoveLegacyClassAliasRector\Fixture;

class MySpecTestCase
{
    public function foo(): void
    {
    }
}

?>
