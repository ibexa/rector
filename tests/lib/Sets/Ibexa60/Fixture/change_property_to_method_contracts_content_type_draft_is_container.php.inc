<?php

namespace Rector\Tests\TypeDeclaration\Rector\ReplaceCartMoneyFactoryRector\Fixture;

use Ibexa\Contracts\Core\Repository\Values\ContentType\ContentTypeDraft;

readonly class Foo
{
    public function foo(ContentTypeDraft $contentTypeDraft): array
    {
        return [$contentTypeDraft->isContainer];
    }
}

?>
-----
<?php

namespace Rector\Tests\TypeDeclaration\Rector\ReplaceCartMoneyFactoryRector\Fixture;

use Ibexa\Contracts\Core\Repository\Values\ContentType\ContentTypeDraft;

readonly class Foo
{
    public function foo(ContentTypeDraft $contentTypeDraft): array
    {
        return [$contentTypeDraft->isContainer()];
    }
}

?>
