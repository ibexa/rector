<?php

namespace Ibexa\Rector\Tests\Rule\OptionsArrayToNamedArgumentsRector\Fixture;

use Ibexa\Contracts\Core\Validation\Constraint\UniqueIdentifier;

final class UniqueProjectCode extends UniqueIdentifier
{
    public function __construct(public string $scope)
    {
        parent::__construct(['identifierPath' => 'code', 'message' => 'Code already used']);
    }
}

final class SkipOtherParent extends \ArrayObject
{
    public function __construct()
    {
        parent::__construct(['identifierPath' => 'code']);
    }
}

?>
-----
<?php

namespace Ibexa\Rector\Tests\Rule\OptionsArrayToNamedArgumentsRector\Fixture;

use Ibexa\Contracts\Core\Validation\Constraint\UniqueIdentifier;

final class UniqueProjectCode extends UniqueIdentifier
{
    public function __construct(public string $scope)
    {
        parent::__construct(identifierPath: 'code', message: 'Code already used');
    }
}

final class SkipOtherParent extends \ArrayObject
{
    public function __construct()
    {
        parent::__construct(['identifierPath' => 'code']);
    }
}

?>
