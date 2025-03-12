<?php

namespace Ibexa\Rector\Tests\Sets\Ibexa50\Fixture;

use Ibexa\Bundle\FieldTypePage\DependencyInjection\Compiler\BlockDefinitionConfigurationCompilerPass;

class Foo {
    public function foo(): array
    {
        return [
            BlockDefinitionConfigurationCompilerPass::EXTENSION_CONFIG_KEY,
            \Ibexa\Bundle\FieldTypePage\DependencyInjection\Compiler\AbstractConfigurationAwareCompilerPass::EXTENSION_CONFIG_KEY
        ];
    }

}

?>
-----
<?php

namespace Ibexa\Rector\Tests\Sets\Ibexa50\Fixture;

use Ibexa\Bundle\FieldTypePage\DependencyInjection\IbexaFieldTypePageExtension;
use Ibexa\Bundle\FieldTypePage\DependencyInjection\Compiler\BlockDefinitionConfigurationCompilerPass;

class Foo {
    public function foo(): array
    {
        return [
            IbexaFieldTypePageExtension::EXTENSION_NAME,
            IbexaFieldTypePageExtension::EXTENSION_NAME
        ];
    }

}

?>
