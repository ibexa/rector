<?php
declare(strict_types=1);
namespace Ibexa\Segmentation\Validation\Constraint;

use Symfony\Component\Validator\Constraint;

#[\Attribute(\Attribute::TARGET_CLASS)]
final class UserToSegmentAssignment extends Constraint
{

}
