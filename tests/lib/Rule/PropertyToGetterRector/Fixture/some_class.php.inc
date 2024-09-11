<?php /** @noinspection ALL */

namespace Ibexa\Rector\Tests\Rule\PropertyToGetterRector\Fixture;

class SomeClass
{
    public ?int $foo;

    public function getFoo(): ?int
    {
        return $this->foo;
    }
}

$some = new SomeClass();
$some->foo;

?>
-----
<?php /** @noinspection ALL */

namespace Ibexa\Rector\Tests\Rule\PropertyToGetterRector\Fixture;

class SomeClass
{
    public ?int $foo;

    public function getFoo(): ?int
    {
        return $this->foo;
    }
}

$some = new SomeClass();
$some->getFoo();

?>
