<?php

namespace Rector\Tests\TypeDeclaration\Rector\ReplaceCartMoneyFactoryRector\Fixture;

use Ibexa\Solr\Gateway\UpdateSerializer;

readonly class Foo
{
    public function __construct(UpdateSerializer $updateSerializer)
    {
    }
}

?>
-----
<?php

namespace Rector\Tests\TypeDeclaration\Rector\ReplaceCartMoneyFactoryRector\Fixture;

use Ibexa\Solr\Gateway\UpdateSerializer\XmlUpdateSerializer;

readonly class Foo
{
    public function __construct(XmlUpdateSerializer $updateSerializer)
    {
    }
}

?>
