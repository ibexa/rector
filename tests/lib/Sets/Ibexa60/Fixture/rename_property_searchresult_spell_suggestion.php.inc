<?php

namespace Rector\Tests\TypeDeclaration\Rector\ReplaceCartMoneyFactoryRector\Fixture;

use Ibexa\Contracts\Core\Repository\Values\Content\Search\SearchResult;

readonly class Foo
{
    public function foo(SearchResult $searchResult): array
    {
        return [$searchResult->spellSuggestion];
    }
}

?>
-----
<?php

namespace Rector\Tests\TypeDeclaration\Rector\ReplaceCartMoneyFactoryRector\Fixture;

use Ibexa\Contracts\Core\Repository\Values\Content\Search\SearchResult;

readonly class Foo
{
    public function foo(SearchResult $searchResult): array
    {
        return [$searchResult->spellcheck];
    }
}

?>
