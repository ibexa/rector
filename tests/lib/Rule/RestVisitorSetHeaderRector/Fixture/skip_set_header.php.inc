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
    private function visitor(): Visitor
    {
    }

    private function headerName(): string
    {
    }

    public function skip(Visitor $visitor, OtherHeaderHolder $other, string $type, bool $flag, $unknown, array $args, array $context): void
    {
        $visitor->setHeader('Content-Type', 'application/json');
        $visitor->setHeader('Content-Type', $type);
        $this->visitor()->setHeader('X-Flag', $flag);
        $visitor->setHeader($this->headerName(), $flag);
        $visitor->setHeader('X-Unknown', $unknown);
        $visitor->setHeader(...$args);
        $setHeader = $visitor->setHeader(...);
        $visitor->setHeader('Accept-Patch');
        $other->setHeader('Accept-Patch', false);
        $other->setHeader('Content-Length', 0);
        $unknown->setHeader('Accept-Patch', false);
        // a visitor without a resolvable type can't be told apart from other setHeader() methods
        $context['visitor']->setHeader('Accept-Patch', false);
    }
}

?>
