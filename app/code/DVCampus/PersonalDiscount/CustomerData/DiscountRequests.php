<?php

declare(strict_types=1);

namespace DVCampus\PersonalDiscount\CustomerData;

use DVCampus\PersonalDiscount\Model\ResourceModel\DiscountRequest\Collection as DiscountRequestCollection;

class DiscountRequests implements \Magento\Customer\CustomerData\SectionSourceInterface
{
    private \Magento\Customer\Model\Session $customerSession;

    private \DVCampus\PersonalDiscount\Model\ResourceModel\DiscountRequest\CollectionFactory $discountRequestCollectionFactory;

    /**
     * DiscountRequests constructor.
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \DVCampus\PersonalDiscount\Model\ResourceModel\DiscountRequest\CollectionFactory $discountRequestCollectionFactory
     */
    public function __construct(
        \Magento\Customer\Model\Session $customerSession,
        \DVCampus\PersonalDiscount\Model\ResourceModel\DiscountRequest\CollectionFactory $discountRequestCollectionFactory
    ) {
        $this->customerSession = $customerSession;
        $this->discountRequestCollectionFactory = $discountRequestCollectionFactory;
    }

    /**
     * @return array|void
     */
    public function getSectionData(): ?array
    {
        if ($this->customerSession->isLoggedIn()) {
            $customerEmail = $this->customerSession->getCustomer()->getEmail();
            /** @var DiscountRequestCollection $discountRequestCollection */
            $discountRequestCollection = $this->discountRequestCollectionFactory->create();
            $discountRequestCollection->addFieldToFilter('customer_id', $this->customerSession->getCustomerId());
            $productIds = $discountRequestCollection->getColumnValues('product_id');
        } else {
            $customerEmail = $this->customerSession->getDiscountRequestCustomerEmail();
            $productIds = $this->customerSession->getDiscountRequestProductIds();
        }

        return [
            'email' => $customerEmail,
            'productIds' => $productIds
        ];
    }
}
