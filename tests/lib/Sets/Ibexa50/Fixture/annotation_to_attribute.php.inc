<?php

namespace Ibexa\Rector\Tests\Sets\Ibexa50\Fixture;

use Ibexa\Payment\Validation\Constraints\UniquePaymentMethodIdentifier;
use Ibexa\Segmentation\Validation\Constraint\UserToSegmentAssignment;

/**
 * @UserToSegmentAssignment()
 */
class Foo
{
    /** @UniquePaymentMethodIdentifier */
    public string $uniquePaymentIdentifier;

    /**
     * @UniquePaymentMethodIdentifier
     */
    public function getUniquePaymentIdentifier(): string
    {
        return $this->uniquePaymentIdentifier;
    }
}

?>
-----
<?php

namespace Ibexa\Rector\Tests\Sets\Ibexa50\Fixture;

use Ibexa\Payment\Validation\Constraints\UniquePaymentMethodIdentifier;
use Ibexa\Segmentation\Validation\Constraint\UserToSegmentAssignment;

#[UserToSegmentAssignment]
class Foo
{
    #[UniquePaymentMethodIdentifier]
    public string $uniquePaymentIdentifier;

    #[UniquePaymentMethodIdentifier]
    public function getUniquePaymentIdentifier(): string
    {
        return $this->uniquePaymentIdentifier;
    }
}

?>
