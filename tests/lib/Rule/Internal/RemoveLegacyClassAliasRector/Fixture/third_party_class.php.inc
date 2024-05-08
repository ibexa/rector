<?php /** @noinspection ALL */

namespace Ibexa\Rector\Tests\Rule\Internal\RemoveLegacyClassAliasRector\Fixture;

class ThirdPartyClass
{
    public function foo(): void
    {
    }
}

// this is not ours, should remain
class_alias(ThirdPartyClass::class, 'ThirdPartyVendor\Accidental\Ibexa\Collsion');

?>
-----
<?php /** @noinspection ALL */

namespace Ibexa\Rector\Tests\Rule\Internal\RemoveLegacyClassAliasRector\Fixture;

class ThirdPartyClass
{
    public function foo(): void
    {
    }
}

// this is not ours, should remain
class_alias(ThirdPartyClass::class, 'ThirdPartyVendor\Accidental\Ibexa\Collsion');

?>
