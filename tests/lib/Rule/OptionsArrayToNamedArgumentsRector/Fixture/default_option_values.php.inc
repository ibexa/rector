<?php

namespace Ibexa\Rector\Tests\Rule\OptionsArrayToNamedArgumentsRector\Fixture;

use Ibexa\FieldTypePage\Validator\Constraints\ContentType;

final class DefaultOptionValues
{
    #[ContentType(['folder', 'article'])]
    public $list;

    #[ContentType(['types' => ['folder'], 'message' => 'Not a folder'])]
    public $keyed;

    public function build(): array
    {
        return [
            new ContentType('folder'),
            new ContentType(['folder', 'article'], ['Default']),
            new ContentType(['types' => 'folder', 'groups' => 'Default']),
        ];
    }
}

?>
-----
<?php

namespace Ibexa\Rector\Tests\Rule\OptionsArrayToNamedArgumentsRector\Fixture;

use Ibexa\FieldTypePage\Validator\Constraints\ContentType;

final class DefaultOptionValues
{
    #[ContentType(types: ['folder', 'article'])]
    public $list;

    #[ContentType(types: ['folder'], message: 'Not a folder')]
    public $keyed;

    public function build(): array
    {
        return [
            new ContentType(types: 'folder'),
            new ContentType(types: ['folder', 'article'], groups: ['Default']),
            new ContentType(types: 'folder', groups: ['Default']),
        ];
    }
}

?>
