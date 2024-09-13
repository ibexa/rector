<?php

namespace Ibexa\Rector\Tests\Sets\Ibexa50\Fixture;

use Ibexa\Contracts\Core\Repository\Values\Content\Field;
use Ibexa\Contracts\Core\Repository\Values\ContentType\ContentType;
use Ibexa\Contracts\Rest\Output\Generator;
use Ibexa\Rest\Output\FieldTypeSerializer;

class Foo {
    public function mediaTypeGenerator(): void
    {
        $generator = new Generator();

        return $generator->generateMediaType('name', 'type');
    }

    public function fieldTypeSerializer(): void
    {
        $serializer = new FieldTypeSerializer();

        $generator = new Generator();
        $contentType = new ContentType();
        $field = new Field();

        return $serializer->serializeFieldValue($generator, $contentType, $field);
    }
}

?>
-----
<?php

namespace Ibexa\Rector\Tests\Sets\Ibexa50\Fixture;

use Ibexa\Contracts\Core\Repository\Values\Content\Field;
use Ibexa\Contracts\Core\Repository\Values\ContentType\ContentType;
use Ibexa\Contracts\Rest\Output\Generator;
use Ibexa\Rest\Output\FieldTypeSerializer;

class Foo {
    public function mediaTypeGenerator(): void
    {
        $generator = new Generator();

        return $generator->generateMediaTypeWithVendor('name', 'type');
    }

    public function fieldTypeSerializer(): void
    {
        $serializer = new FieldTypeSerializer();

        $generator = new Generator();
        $contentType = new ContentType();
        $field = new Field();

        return $serializer->serializeContentFieldValue($generator, $field);
    }
}

?>
