<?php

namespace Ibexa\Rector\Tests\Sets\Ibexa50\Fixture;

use Ibexa\Core\Search\Common\FieldNameResolver;

readonly class Foo
{
    public function foo(FieldNameResolver $contentTypeDraft): array
    {
        return [$contentTypeDraft->getFieldNames()];
    }
}

?>
-----
<?php

namespace Ibexa\Rector\Tests\Sets\Ibexa50\Fixture;

use Ibexa\Core\Search\Common\FieldNameResolver;

readonly class Foo
{
    public function foo(FieldNameResolver $contentTypeDraft): array
    {
        return [$contentTypeDraft->getFieldTypes()];
    }
}

?>
