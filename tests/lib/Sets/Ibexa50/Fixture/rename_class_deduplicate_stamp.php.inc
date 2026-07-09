<?php

namespace Ibexa\Rector\Tests\Sets\Ibexa50\Fixture;

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

namespace Ibexa\Rector\Tests\Sets\Ibexa50\Fixture;

use Ibexa\Contracts\Messenger\Stamp\DeduplicateStamp;

class DeduplicateStampUsage
{
    public function createStamp(): DeduplicateStamp
    {
        return new DeduplicateStamp('key');
    }
}

?>
