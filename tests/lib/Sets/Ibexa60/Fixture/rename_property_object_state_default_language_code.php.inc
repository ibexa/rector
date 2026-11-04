<?php

namespace Ibexa\Rector\Tests\Sets\Ibexa60\Fixture;

use Ibexa\Contracts\Core\Repository\Values\ObjectState\ObjectState;
use Ibexa\Contracts\Core\Repository\Values\ObjectState\ObjectStateGroup;

class SomeObjectStateLanguages
{
    public function get(ObjectStateGroup $group, ObjectState $state): array
    {
        return [$group->defaultLanguageCode, $state->defaultLanguageCode];
    }
}

?>
-----
<?php

namespace Ibexa\Rector\Tests\Sets\Ibexa60\Fixture;

use Ibexa\Contracts\Core\Repository\Values\ObjectState\ObjectState;
use Ibexa\Contracts\Core\Repository\Values\ObjectState\ObjectStateGroup;

class SomeObjectStateLanguages
{
    public function get(ObjectStateGroup $group, ObjectState $state): array
    {
        return [$group->mainLanguageCode, $state->mainLanguageCode];
    }
}

?>
