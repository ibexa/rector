<?php

namespace Ibexa\Rector\Tests\Rule\RestVisitorSetHeaderRector\Fixture;

use Ibexa\Contracts\Rest\Output\Visitor;

final class CustomVisitor extends Visitor
{
}

final class SetHeaderValue
{
    public function suppress(Visitor $visitor, ?Visitor $maybeVisitor, CustomVisitor $customVisitor): void
    {
        $visitor->setHeader('Accept-Patch', false);
        $visitor->setHeader(value: false, name: 'Accept-Patch');
        $maybeVisitor?->setHeader('Accept-Patch', false);
        $customVisitor->setHeader('Accept-Patch', false);
    }

    public function stringify(Visitor $visitor, int $length, int|string $id): void
    {
        $visitor->setHeader('X-Flag', true);
        $visitor->setHeader('Content-Length', 0);
        $visitor->setHeader('Content-Length', $length);
        $visitor->setHeader('X-Id', $id);
    }
}

?>
-----
<?php

namespace Ibexa\Rector\Tests\Rule\RestVisitorSetHeaderRector\Fixture;

use Ibexa\Contracts\Rest\Output\Visitor;

final class CustomVisitor extends Visitor
{
}

final class SetHeaderValue
{
    public function suppress(Visitor $visitor, ?Visitor $maybeVisitor, CustomVisitor $customVisitor): void
    {
        $visitor->suppressHeader('Accept-Patch');
        $visitor->suppressHeader(name: 'Accept-Patch');
        $maybeVisitor?->suppressHeader('Accept-Patch');
        $customVisitor->suppressHeader('Accept-Patch');
    }

    public function stringify(Visitor $visitor, int $length, int|string $id): void
    {
        $visitor->setHeader('X-Flag', '1');
        $visitor->setHeader('Content-Length', '0');
        $visitor->setHeader('Content-Length', (string) $length);
        $visitor->setHeader('X-Id', (string) $id);
    }
}

?>
