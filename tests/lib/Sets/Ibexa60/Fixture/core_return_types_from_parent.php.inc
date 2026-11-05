<?php

namespace Ibexa\Rector\Tests\Sets\Ibexa60\Fixture;

use Ibexa\Bundle\Core\Imagine\Filter\UnsupportedFilter;
use Ibexa\Core\MVC\Symfony\Templating\Twig\Extension\FieldRenderingExtension;
use Imagine\Image\ImageInterface;

class SomeUnsupportedFilter extends UnsupportedFilter
{
    public function apply(ImageInterface $image)
    {
        return $image;
    }
}

class SomeFieldRenderingExtension extends FieldRenderingExtension
{
    public function getFunctions()
    {
        return [];
    }
}

?>
-----
<?php

namespace Ibexa\Rector\Tests\Sets\Ibexa60\Fixture;

use Ibexa\Bundle\Core\Imagine\Filter\UnsupportedFilter;
use Ibexa\Core\MVC\Symfony\Templating\Twig\Extension\FieldRenderingExtension;
use Imagine\Image\ImageInterface;

class SomeUnsupportedFilter extends UnsupportedFilter
{
    public function apply(ImageInterface $image): ImageInterface
    {
        return $image;
    }
}

class SomeFieldRenderingExtension extends FieldRenderingExtension
{
    public function getFunctions(): array
    {
        return [];
    }
}

?>
