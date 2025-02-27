<?php

namespace Rector\Tests\TypeDeclaration\Rector\ReplaceCartMoneyFactoryRector\Fixture;

use Ibexa\Solr\Query\Content\CriterionVisitor\Field;

readonly class Foo
{
    public function __construct(Field $field)
    {
    }
}

?>
-----
<?php

namespace Rector\Tests\TypeDeclaration\Rector\ReplaceCartMoneyFactoryRector\Fixture;

use Ibexa\Solr\Query\Common\CriterionVisitor\Field;

readonly class Foo
{
    public function __construct(Field $field)
    {
    }
}

?>
