<?php /** @noinspection ALL */

use Ibexa\Rector\Tests\Rule\Internal\RemoveInterfaceWithMethods\Fixture\SomeInterface;

class SomeClass implements SomeInterface
{
    public function someMethod(): array
    {
        return ['ezplatform:some_old:command_with_interface'];
    }
}

?>
-----
<?php /** @noinspection ALL */

use Ibexa\Rector\Tests\Rule\Internal\RemoveInterfaceWithMethods\Fixture\SomeInterface;

class SomeClass
{
}

?>
