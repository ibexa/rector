<?php

namespace Ibexa\Rector\Tests\Sets\Ibexa60\Fixture;

use Countable;
use Ibexa\Bundle\Core\Command\BackwardCompatibleCommand;

class SomeCommand implements Countable, BackwardCompatibleCommand
{
    public function count(): int
    {
        return 0;
    }

    public function getDeprecatedAliases(): array
    {
        return ['ezplatform:some'];
    }
}

?>
-----
<?php

namespace Ibexa\Rector\Tests\Sets\Ibexa60\Fixture;

use Countable;
use Ibexa\Bundle\Core\Command\BackwardCompatibleCommand;

class SomeCommand implements Countable
{
    public function count(): int
    {
        return 0;
    }

    public function getDeprecatedAliases(): array
    {
        return ['ezplatform:some'];
    }
}

?>
