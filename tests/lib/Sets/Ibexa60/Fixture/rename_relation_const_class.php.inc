<?php

namespace Ibexa\Rector\Tests\Sets\Ibexa60\Fixture;

use Ibexa\Contracts\Core\Repository\Values\Content\Relation;

readonly class Foo
{
    public function bar(Relation $relation)
    {
        $type = Relation::FIELD;
    }
}

?>
-----
<?php

namespace Ibexa\Rector\Tests\Sets\Ibexa60\Fixture;

use Ibexa\Contracts\Core\Repository\Values\Content\RelationType;
use Ibexa\Contracts\Core\Repository\Values\Content\Relation;

readonly class Foo
{
    public function bar(Relation $relation)
    {
        $type = RelationType::FIELD->value;
    }
}

?>
