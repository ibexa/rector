<?php

namespace Ibexa\Rector\Tests\Sets\Ibexa50\Fixture;

use Ibexa\Contracts\Core\Repository\Values\Content\Relation;

readonly class Foo
{
    public function bar()
    {
        $type = Relation::FIELD;
    }
}

?>
-----
<?php

namespace Ibexa\Rector\Tests\Sets\Ibexa50\Fixture;

use Ibexa\Contracts\Core\Repository\Values\Content\RelationType;

readonly class Foo
{
    public function bar()
    {
        $type = RelationType::FIELD;
    }
}

?>
