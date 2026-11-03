<?php

namespace Ibexa\Rector\Tests\Rule\RestVisitorSetHeaderRector\Fixture;

use Ibexa\Contracts\Rest\Output\Visitor;

final class OtherHeaderHolder
{
    public function setHeader(string $name, mixed $value): void
    {
    }
}

final class SkipSetHeader
{
    public function skip(Visitor $visitor, OtherHeaderHolder $other, string $type, bool $flag, $unknown, array $args): void
    {
        $visitor->setHeader('Content-Type', 'application/json');
        $visitor->setHeader('Content-Type', $type);
        $visitor->setHeader('X-Flag', $flag);
        $visitor->setHeader('X-Unknown', $unknown);
        $visitor->setHeader(...$args);
        $setHeader = $visitor->setHeader(...);
        $visitor->setHeader('Accept-Patch');
        $other->setHeader('Accept-Patch', false);
        $other->setHeader('Content-Length', 0);
        $unknown->setHeader('Accept-Patch', false);
    }
}

?>
