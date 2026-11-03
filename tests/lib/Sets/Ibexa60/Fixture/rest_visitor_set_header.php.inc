<?php

namespace Ibexa\Rector\Tests\Sets\Ibexa60\Fixture;

use Ibexa\Contracts\Rest\Output\Visitor;

final class RestVisitorSetHeader
{
    public function visit(Visitor $visitor): void
    {
        $visitor->setHeader('Accept-Patch', false);
        $visitor->setHeader('Content-Length', 0);
    }
}

?>
-----
<?php

namespace Ibexa\Rector\Tests\Sets\Ibexa60\Fixture;

use Ibexa\Contracts\Rest\Output\Visitor;

final class RestVisitorSetHeader
{
    public function visit(Visitor $visitor): void
    {
        $visitor->suppressHeader('Accept-Patch');
        $visitor->setHeader('Content-Length', '0');
    }
}

?>
