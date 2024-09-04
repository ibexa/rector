<?php

namespace Ibexa\Rector\Tests\Sets\Ibexa50\Fixture;

use Ibexa\Bundle\Core\ApiLoader\RepositoryConfigurationProvider;

class Foo {
    public function mediaTypeGenerator(): void
    {
        $generator = new \Ibexa\Contracts\Rest\Output\Generator();

        return $generator->generateMediaType('name', 'type');
    }

    public function fieldTypeSerializer(): void
    {
        $serializer = new \Ibexa\Rest\Output\FieldTypeSerializer();

        $generator = new \Ibexa\Contracts\Rest\Output\Generator();
        $contentType = new \Ibexa\Contracts\Core\Repository\Values\ContentType\ContentType();
        $field = new \Ibexa\Contracts\Core\Repository\Values\Content\Field();

        return $serializer->serializeFieldValue($generator, $contentType, $field);
    }
}

?>
-----
<?php

namespace Ibexa\Rector\Tests\Sets\Ibexa50\Fixture;

use Ibexa\Bundle\Core\ApiLoader\RepositoryConfigurationProvider;

class Foo {
    public function mediaTypeGenerator(): void
    {
        $generator = new \Ibexa\Contracts\Rest\Output\Generator();

        return $generator->generateMediaTypeWithVendor('name', 'type');
    }

    public function fieldTypeSerializer(): void
    {
        $serializer = new \Ibexa\Rest\Output\FieldTypeSerializer();

        $generator = new \Ibexa\Contracts\Rest\Output\Generator();
        $contentType = new \Ibexa\Contracts\Core\Repository\Values\ContentType\ContentType();
        $field = new \Ibexa\Contracts\Core\Repository\Values\Content\Field();

        return $serializer->serializeContentFieldValue($generator, $field);
    }
}

?>
