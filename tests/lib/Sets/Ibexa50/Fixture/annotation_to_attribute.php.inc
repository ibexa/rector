<?php
declare(strict_types=1);

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
declare(strict_types=1);

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
