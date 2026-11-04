<?php

namespace Ibexa\Rector\Tests\Sets\Ibexa60\Fixture;

use Ibexa\Core\Search\Legacy\Content\Common\Gateway\CriterionHandler\Field;
use Ibexa\Core\Search\Legacy\Content\Common\Gateway\CriterionHandler\FieldEmpty;
use Ibexa\Core\Search\Legacy\Content\Common\Gateway\CriterionHandler\FullText;

final class CustomField extends Field
{
    public function __construct(object $connection, object $contentTypeHandler, object $languageHandler, object $registry, object $valueConverter, object $processor)
    {
        parent::__construct($connection, $contentTypeHandler, $languageHandler, $registry, $valueConverter, $processor);
    }
}

final class CustomFieldEmpty extends FieldEmpty
{
    public function __construct(object $connection, object $contentTypeHandler, object $languageHandler, object $registry, object $fieldTypeService)
    {
        parent::__construct($connection, $contentTypeHandler, $languageHandler, $registry, $fieldTypeService);
    }
}

final class CustomFullText extends FullText
{
    public function __construct(object $connection, object $processor, object $languageMaskGenerator, array $configuration = [])
    {
        parent::__construct($connection, $processor, $languageMaskGenerator, $configuration);
    }
}

?>
-----
<?php

namespace Ibexa\Rector\Tests\Sets\Ibexa60\Fixture;

use Ibexa\Core\Persistence\Doctrine\JoinedTablesTracker;
use Ibexa\Core\Search\Legacy\Content\Common\Gateway\CriterionHandler\Field;
use Ibexa\Core\Search\Legacy\Content\Common\Gateway\CriterionHandler\FieldEmpty;
use Ibexa\Core\Search\Legacy\Content\Common\Gateway\CriterionHandler\FullText;

final class CustomField extends Field
{
    public function __construct(object $connection, object $contentTypeHandler, object $languageHandler, object $registry, object $valueConverter, object $processor, JoinedTablesTracker $joinedTablesTracker)
    {
        parent::__construct($connection, $contentTypeHandler, $languageHandler, $registry, $valueConverter, $processor, $joinedTablesTracker);
    }
}

final class CustomFieldEmpty extends FieldEmpty
{
    public function __construct(object $connection, object $contentTypeHandler, object $languageHandler, object $registry, object $fieldTypeService, JoinedTablesTracker $joinedTablesTracker)
    {
        parent::__construct($connection, $contentTypeHandler, $languageHandler, $registry, $fieldTypeService, $joinedTablesTracker);
    }
}

final class CustomFullText extends FullText
{
    public function __construct(object $connection, object $processor, object $languageMaskGenerator, JoinedTablesTracker $joinedTablesTracker, array $configuration = [])
    {
        parent::__construct($connection, $processor, $languageMaskGenerator, $joinedTablesTracker, $configuration);
    }
}

?>
