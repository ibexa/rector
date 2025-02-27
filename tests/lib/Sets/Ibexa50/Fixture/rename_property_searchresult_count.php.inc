<?php

namespace Rector\Tests\TypeDeclaration\Rector\ReplaceCartMoneyFactoryRector\Fixture;

use Ibexa\Contracts\Core\Repository\Values\Content\Trash\SearchResult;

readonly class Foo
{
    public function foo(SearchResult $searchResult): string
    {
        return $searchResult->count;
    }
}

?>
-----
<?php

namespace Rector\Tests\TypeDeclaration\Rector\ReplaceCartMoneyFactoryRector\Fixture;

use Ibexa\Contracts\Core\Repository\Values\Content\Trash\SearchResult;

readonly class Foo
{
    public function foo(SearchResult $searchResult): string
    {
        return $searchResult->totalCount;
    }
}

?>
