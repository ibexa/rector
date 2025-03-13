<?php

namespace Rector\Tests\TypeDeclaration\Rector\ReplaceCartMoneyFactoryRector\Fixture;

use Ibexa\Migration\ValueObject\ContentType\Matcher;

readonly class Foo
{
    public function fooBar(): string
    {
        return Matcher::CONTENT_TYPE_IDENTIFIER;
    }
}

?>
-----
<?php

namespace Rector\Tests\TypeDeclaration\Rector\ReplaceCartMoneyFactoryRector\Fixture;

use Ibexa\Migration\StepExecutor\ContentType\IdentifierFinder;
use Ibexa\Migration\ValueObject\ContentType\Matcher;

readonly class Foo
{
    public function fooBar(): string
    {
        return IdentifierFinder::CONTENT_TYPE_IDENTIFIER;
    }
}

?>
