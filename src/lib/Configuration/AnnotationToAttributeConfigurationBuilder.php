<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Rector\Configuration;

use Rector\Php80\ValueObject\AnnotationToAttribute;

final readonly class AnnotationToAttributeConfigurationBuilder
{
    /**
     * @return iterable<\Rector\Php80\ValueObject\AnnotationToAttribute>
     */
    public function build(): iterable
    {
        foreach (IbexaSymfonyConstraintList::cases() as $constraintFQCN) {
            yield new AnnotationToAttribute($constraintFQCN->value);
        }
    }
}
