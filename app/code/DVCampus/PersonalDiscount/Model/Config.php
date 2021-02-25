<?php

declare(strict_types=1);

namespace DVCampus\PersonalDiscount\Model;

use Magento\Store\Model\ScopeInterface;

class Config extends \Magento\Framework\App\Helper\AbstractHelper
{
    public const XML_PATH_DV_CAMPUS_PERSONAL_DISCOUNT_GENERAL_ENABLED
        = 'dv_campus_personal_discount/general/enabled';

    public const XML_PATH_DV_CAMPUS_PERSONAL_DISCOUNT_GENERAL_ALLOW_FOR_GUESTS
        = 'dv_campus_personal_discount/general/allow_for_guests';

    public const XML_PATH_DV_CAMPUS_PERSONAL_DISCOUNT_GENERAL_SALES_EMAIL_IDENTITY
        = 'dv_campus_personal_discount/general/sender_email_identity';

    /**
     * @return bool
     */
    public function enabled(): bool
    {
        return (bool) $this->scopeConfig->getValue(
            self::XML_PATH_DV_CAMPUS_PERSONAL_DISCOUNT_GENERAL_ENABLED,
            ScopeInterface::SCOPE_WEBSITE
        );
    }

    /**
     * @return bool
     */
    public function allowForGuests(): bool
    {
        return (bool) $this->scopeConfig->getValue(
            self::XML_PATH_DV_CAMPUS_PERSONAL_DISCOUNT_GENERAL_ALLOW_FOR_GUESTS,
            ScopeInterface::SCOPE_WEBSITE
        );
    }

    /**
     * @return string
     */
    public function getSenderEmailIdentity(): string
    {
        return (string) $this->scopeConfig->getValue(
            self::XML_PATH_DV_CAMPUS_PERSONAL_DISCOUNT_GENERAL_SALES_EMAIL_IDENTITY,
            ScopeInterface::SCOPE_STORE
        );
    }
}
