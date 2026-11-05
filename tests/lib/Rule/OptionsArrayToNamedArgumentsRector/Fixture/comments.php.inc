<?php

namespace Ibexa\Rector\Tests\Rule\OptionsArrayToNamedArgumentsRector\Fixture;

use Ibexa\AdminUi\Validator\Constraints\LocationIsContainer;

final class Comments
{
    public function build(): LocationIsContainer
    {
        return new LocationIsContainer([
            // shown in the location picker
            'message' => 'Not a container',
            'groups' => ['Default'],
        ]);
    }
}

?>
-----
<?php

namespace Ibexa\Rector\Tests\Rule\OptionsArrayToNamedArgumentsRector\Fixture;

use Ibexa\AdminUi\Validator\Constraints\LocationIsContainer;

final class Comments
{
    public function build(): LocationIsContainer
    {
        return new LocationIsContainer(
            // shown in the location picker
            message: 'Not a container',
            groups: ['Default']
        );
    }
}

?>
