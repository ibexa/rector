<?php /** @noinspection ALL */

use Ibexa\Bundle\Core\Command\BackwardCompatibleCommand;
use OtherInterface;

class SomeClass implements BackwardCompatibleCommand, OtherInterface
{
    public function firstMethod()
    {

    }

    public function getDeprecatedAliases(): array
    {
        return ['ezplatform:some_old:command_with_interface'];
    }
}

?>
-----
<?php /** @noinspection ALL */

use Ibexa\Bundle\Core\Command\BackwardCompatibleCommand;
use OtherInterface;

class SomeClass implements OtherInterface
{
    public function firstMethod()
    {

    }
}

?>
