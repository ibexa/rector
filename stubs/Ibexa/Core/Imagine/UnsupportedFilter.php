<?php

namespace Ibexa\Bundle\Core\Imagine\Filter;

use Imagine\Image\ImageInterface;

class UnsupportedFilter
{
    public function apply(ImageInterface $image): ImageInterface
    {
    }
}
