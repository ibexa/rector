<?php /** @noinspection ALL */

use Ibexa\Rector\Tests\Rule\Internal\RemoveInterfaceWithMethods\Fixture\SomeInterface;
use OtherInterface;

class SomeClass implements SomeInterface, OtherInterface
{
    public function firstMethod()
    {

    }

    public function someMethod(): array
    {
        return ['ezplatform:some_old:command_with_interface'];
    }
}

?>
-----
<?php /** @noinspection ALL */

use Ibexa\Rector\Tests\Rule\Internal\RemoveInterfaceWithMethods\Fixture\SomeInterface;
use OtherInterface;

class SomeClass implements OtherInterface
{
    public function firstMethod()
    {

    }
}

?>
