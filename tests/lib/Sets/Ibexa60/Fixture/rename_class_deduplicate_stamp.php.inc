<?php

namespace Ibexa\Rector\Tests\Sets\Ibexa60\Fixture;

use Ibexa\Bundle\Messenger\Stamp\DeduplicateStamp;

class DeduplicateStampUsage
{
    public function createStamp(): DeduplicateStamp
    {
        return new DeduplicateStamp('key');
    }
}

?>
-----
<?php

namespace Ibexa\Rector\Tests\Sets\Ibexa60\Fixture;

use Symfony\Component\Messenger\Stamp\DeduplicateStamp;

class DeduplicateStampUsage
{
    public function createStamp(): DeduplicateStamp
    {
        return new DeduplicateStamp('key');
    }
}

?>
