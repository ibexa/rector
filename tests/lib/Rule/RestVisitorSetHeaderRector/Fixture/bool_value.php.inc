<?php

namespace Ibexa\Rector\Tests\Rule\RestVisitorSetHeaderRector\Fixture;

use Ibexa\Contracts\Rest\Output\Visitor;

final class BoolValue
{
    private Visitor $visitor;

    public function visit(Visitor $visitor, bool $isSingleResource): void
    {
        $visitor->setHeader('Accept-Patch', $isSingleResource);
        $this->visitor->setHeader(name: 'Accept-Patch', value: $this->isSingle());
    }

    private function isSingle(): bool
    {
        return true;
    }
}

?>
-----
<?php

namespace Ibexa\Rector\Tests\Rule\RestVisitorSetHeaderRector\Fixture;

use Ibexa\Contracts\Rest\Output\Visitor;

final class BoolValue
{
    private Visitor $visitor;

    public function visit(Visitor $visitor, bool $isSingleResource): void
    {
        $isSingleResource ? $visitor->setHeader('Accept-Patch', '1') : $visitor->suppressHeader('Accept-Patch');
        $this->isSingle() ? $this->visitor->setHeader(name: 'Accept-Patch', value: '1') : $this->visitor->suppressHeader(name: 'Accept-Patch');
    }

    private function isSingle(): bool
    {
        return true;
    }
}

?>
