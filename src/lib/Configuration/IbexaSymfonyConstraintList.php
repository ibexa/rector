<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Rector\Configuration;

enum IbexaSymfonyConstraintList: string
{
    // Segmentation
    case SegmentationUserToSegmentAssignment = 'Ibexa\Segmentation\Validation\Constraint\UserToSegmentAssignment';
    case SegmentationUniqueSegmentGroupStructIdentifier = 'Ibexa\Segmentation\Validation\Constraint\UniqueSegmentGroupStructIdentifier';
    case SegmentationUniqueSegmentStructIdentifier = 'Ibexa\Segmentation\Validation\Constraint\UniqueSegmentStructIdentifier';

    // Connector AI
    case ConnectorAiActionConfigurationHandlerOptions = 'Ibexa\ConnectorAi\Validation\Constraints\ActionConfigurationHandlerOptions';
    case ConnectorAiActionConfigurationTypeOptions = 'Ibexa\ConnectorAi\Validation\Constraints\ActionConfigurationTypeOptions';
    case ConnectorAiUniqueActionConfigurationIdentifier = 'Ibexa\ConnectorAi\Validation\Constraints\UniqueActionConfigurationIdentifier';
    case ConnectorAiIdentifier = 'Ibexa\ConnectorAi\Validation\Constraints\Identifier';

    // Discounts
    case DiscountsAtLeastOneDiscountTranslationWillRemain = 'Ibexa\Discounts\Validation\Constraint\AtLeastOneDiscountTranslationWillRemain';
    case DiscountsCountCategories = 'Ibexa\Discounts\Validation\Constraint\CountCategories';
    case DiscountsCountCustomerGroup = 'Ibexa\Discounts\Validation\Constraint\CountCustomerGroup';
    case DiscountsCountProducts = 'Ibexa\Discounts\Validation\Constraint\CountProducts';
    case DiscountsCurrencyRequired = 'Ibexa\Discounts\Validation\Constraint\CurrencyRequired';
    case DiscountsUniqueIdentifier = 'Ibexa\Discounts\Validation\Constraint\UniqueIdentifier';
    case DiscountsIdentifier = 'Ibexa\Discounts\Validation\Constraint\Identifier';
    case DiscountsValidDiscountRuleType = 'Ibexa\Discounts\Validation\Constraint\ValidDiscountRuleType';

    // Collaboration
    case CollaborationParticipantType = 'Ibexa\Collaboration\Validation\Constraint\ParticipantType';
    case CollaborationUniqueToken = 'Ibexa\Collaboration\Validation\Constraint\UniqueToken';

    // Payment
    case PaymentAllowedPaymentStatusTransition = 'Ibexa\Payment\Validation\Constraints\AllowedPaymentStatusTransition';
    case PaymentAtLeastOneTranslation = 'Ibexa\Payment\Validation\Constraints\AtLeastOneTranslation';
    case PaymentEnabledPaymentMethod = 'Ibexa\Payment\Validation\Constraints\EnabledPaymentMethod';
    case PaymentIdentifier = 'Ibexa\Payment\Validation\Constraints\Identifier';
    case PaymentMoneyAmountEqualToOrGreaterThanZero = 'Ibexa\Payment\Validation\Constraints\MoneyAmountEqualToOrGreaterThanZero';
    case PaymentPaymentMethodEnabled = 'Ibexa\Payment\Validation\Constraints\PaymentMethodEnabled';
    case PaymentPaymentMethodOptions = 'Ibexa\Payment\Validation\Constraints\PaymentMethodOptions';
    case PaymentUniquePaymentIdentifier = 'Ibexa\Payment\Validation\Constraints\UniquePaymentIdentifier';
    case PaymentUniquePaymentMethodIdentifier = 'Ibexa\Payment\Validation\Constraints\UniquePaymentMethodIdentifier';

    // SiteFactory
    case SiteFactoryHostnameWithOptionalPort = 'Ibexa\Bundle\SiteFactory\Validator\Constraints\HostnameWithOptionalPort';
    case SiteFactoryPort = 'Ibexa\Bundle\SiteFactory\Validator\Constraints\Port';
}
