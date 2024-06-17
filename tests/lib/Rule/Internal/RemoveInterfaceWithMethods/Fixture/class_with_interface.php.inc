<?php /** @noinspection ALL */

use Ibexa\Bundle\Core\Command\BackwardCompatibleCommand;

class SomeClass implements BackwardCompatibleCommand
{
    public function getDeprecatedAliases(): array
    {
        return ['ezplatform:some_old:command_with_interface'];
    }
}

?>
-----
<?php /** @noinspection ALL */

use Ibexa\Bundle\Core\Command\BackwardCompatibleCommand;

class SomeClass
{
}

?>
