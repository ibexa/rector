<?php

namespace Rector\Tests\TypeDeclaration\Rector\ReplaceCartMoneyFactoryRector\Fixture;

use Ibexa\Bundle\FormBuilder\DependencyInjection\Configuration;

readonly class Foo
{
    public function fooBar(): string
    {
        return Configuration::TREE_ROOT;
    }
}

?>
-----
<?php

namespace Rector\Tests\TypeDeclaration\Rector\ReplaceCartMoneyFactoryRector\Fixture;

use Ibexa\Bundle\FormBuilder\DependencyInjection\IbexaFormBuilderExtension;
use Ibexa\Bundle\FormBuilder\DependencyInjection\Configuration;

readonly class Foo
{
    public function fooBar(): string
    {
        return IbexaFormBuilderExtension::EXTENSION_NAME;
    }
}

?>
