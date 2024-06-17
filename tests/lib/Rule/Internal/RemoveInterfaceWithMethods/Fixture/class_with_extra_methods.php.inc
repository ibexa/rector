<?php /** @noinspection ALL */

use Ibexa\Bundle\Core\Command\BackwardCompatibleCommand;
use Symfony\Component\Console\Command\Command;

class SomeClass implements BackwardCompatibleCommand
{
    public function firstMethod(): void
    {

    }

    public function getDeprecatedAliases(): array
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

use Ibexa\Bundle\Core\Command\BackwardCompatibleCommand;
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
