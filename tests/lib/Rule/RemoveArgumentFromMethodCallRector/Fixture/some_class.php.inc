<?php /** @noinspection ALL */

namespace Ibexa\Rector\Tests\Rule\RemoveArgumentFromMethodCallRector\Fixture;

class SomeClass
{
    public function foo($a, $b = null, $c = null): void
    {
    }
}

class SomeOtherClass
{
    public function foo($a, $b = null, $c = null): void
    {
    }
}

$a = 'a';
$b = 'b';
$c = 'c';

$some = new SomeClass();
$some->foo($a, $b, $c);

$some->foo($a, $b);

$someOther = new SomeOtherClass();
$someOther->foo($a, $b, $c);
?>
-----
<?php /** @noinspection ALL */

namespace Ibexa\Rector\Tests\Rule\RemoveArgumentFromMethodCallRector\Fixture;

class SomeClass
{
    public function foo($a, $b = null, $c = null): void
    {
    }
}

class SomeOtherClass
{
    public function foo($a, $b = null, $c = null): void
    {
    }
}

$a = 'a';
$b = 'b';
$c = 'c';

$some = new SomeClass();
$some->foo($a, $c);

$some->foo($a, $b);

$someOther = new SomeOtherClass();
$someOther->foo($a, $b, $c);
?>
