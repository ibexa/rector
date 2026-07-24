<?php

namespace Rector\Tests\TypeDeclaration\Rector\ReplaceCartMoneyFactoryRector\Fixture;

use Ibexa\Contracts\Core\Repository\Values\ContentType\ContentType;

readonly class Foo
{
    public function foo(ContentType $contentType): array
    {
        return [$contentType->isContainer];
    }
}

?>
-----
<?php

namespace Rector\Tests\TypeDeclaration\Rector\ReplaceCartMoneyFactoryRector\Fixture;

use Ibexa\Contracts\Core\Repository\Values\ContentType\ContentType;

readonly class Foo
{
    public function foo(ContentType $contentType): array
    {
        return [$contentType->isContainer()];
    }
}

?>
