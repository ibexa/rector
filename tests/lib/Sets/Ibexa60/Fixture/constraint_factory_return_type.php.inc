<?php

namespace Ibexa\Rector\Tests\Sets\Ibexa60\Fixture;

use Ibexa\FieldTypePage\FieldType\Page\Block\Definition\Attribute\Validator\ConstraintFactory;

class SomeConstraintFactory extends ConstraintFactory
{
    public function getConstraint(string $identifier, array $constraint): mixed
    {
        return parent::getConstraint($identifier, $constraint);
    }
}

class SomeUntypedConstraintFactory extends ConstraintFactory
{
    public function getConstraint(string $identifier, array $constraint)
    {
        return parent::getConstraint($identifier, $constraint);
    }
}

?>
-----
<?php

namespace Ibexa\Rector\Tests\Sets\Ibexa60\Fixture;

use Symfony\Component\Validator\Constraint;
use Ibexa\FieldTypePage\FieldType\Page\Block\Definition\Attribute\Validator\ConstraintFactory;

class SomeConstraintFactory extends ConstraintFactory
{
    public function getConstraint(string $identifier, array $constraint): Constraint
    {
        return parent::getConstraint($identifier, $constraint);
    }
}

class SomeUntypedConstraintFactory extends ConstraintFactory
{
    public function getConstraint(string $identifier, array $constraint): Constraint
    {
        return parent::getConstraint($identifier, $constraint);
    }
}

?>
