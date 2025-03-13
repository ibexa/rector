<?php /** @noinspection ALL */

namespace Ibexa\Rector\Tests\Rule\ReplaceInterfaceRector\Fixture;

class SomeClass implements \SomeInterface
{
}

?>
-----
<?php /** @noinspection ALL */

namespace Ibexa\Rector\Tests\Rule\ReplaceInterfaceRector\Fixture;

class SomeClass implements \SomeOtherInterface
{
}

?>
