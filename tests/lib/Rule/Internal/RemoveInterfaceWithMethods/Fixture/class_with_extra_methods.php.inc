<?php /** @noinspection ALL */

use Ibexa\Rector\Tests\Rule\Internal\RemoveInterfaceWithMethods\Fixture\SomeInterface;
use Symfony\Component\Console\Command\Command;

class SomeClass implements SomeInterface
{
    public function firstMethod(): void
    {

    }

    public function someMethod(): array
    {
        return ['ezplatform:some_old:command_with_interface'];
    }

    public function thirdMethod(): void
    {

    }
}

?>
-----
<?php /** @noinspection ALL */

use Ibexa\Rector\Tests\Rule\Internal\RemoveInterfaceWithMethods\Fixture\SomeInterface;
use Symfony\Component\Console\Command\Command;

class SomeClass
{
    public function firstMethod(): void
    {

    }
    public function thirdMethod(): void
    {

    }
}

?>
