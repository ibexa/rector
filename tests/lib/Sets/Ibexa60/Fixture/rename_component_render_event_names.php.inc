<?php

namespace Ibexa\Rector\Tests\Sets\Ibexa60\Fixture;

use Ibexa\AdminUi\Component\Event\RenderGroupEvent;
use Ibexa\AdminUi\Component\Event\RenderSingleEvent;

final class SomeComponentSubscriber
{
    public static function getSubscribedEvents(): array
    {
        return [
            RenderGroupEvent::NAME => 'onRenderGroup',
            RenderSingleEvent::NAME => 'onRenderSingle',
        ];
    }
}

?>
-----
<?php

namespace Ibexa\Rector\Tests\Sets\Ibexa60\Fixture;

use Ibexa\AdminUi\Component\Event\RenderGroupEvent;
use Ibexa\AdminUi\Component\Event\RenderSingleEvent;

final class SomeComponentSubscriber
{
    public static function getSubscribedEvents(): array
    {
        return [
            \Ibexa\Contracts\TwigComponents\Event\RenderGroupEvent::class => 'onRenderGroup',
            \Ibexa\Contracts\TwigComponents\Event\RenderSingleEvent::class => 'onRenderSingle',
        ];
    }
}

?>
