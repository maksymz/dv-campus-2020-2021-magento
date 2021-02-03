<?php

declare(strict_types=1);

namespace DVCampus\PersonalDiscount\CustomerData;

use DVCampus\PersonalDiscount\Model\ResourceModel\DiscountRequest\Collection as DiscountRequestCollection;

class DiscountRequests implements \Magento\Customer\CustomerData\SectionSourceInterface
{
    private \Magento\Customer\Model\Session $customerSession;

    private \DVCampus\PersonalDiscount\Model\ResourceModel\DiscountRequest\CollectionFactory
        $discountRequestCollectionFactory;

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
     * @return array
     */
    public function getSectionData(): array
    {
        $name = (string) $this->customerSession->getDiscountRequestCustomerName();
        $email = (string) $this->customerSession->getDiscountRequestCustomerEmail();

        if ($this->customerSession->isLoggedIn()) {
            if (!$name) {
                $name = $this->customerSession->getCustomer()->getName();
            }

            if (!$email) {
                $email = $this->customerSession->getCustomer()->getEmail();
            }

            /** @var DiscountRequestCollection $discountRequestCollection */
            $discountRequestCollection = $this->discountRequestCollectionFactory->create();
            $discountRequestCollection->addFieldToFilter('customer_id', $this->customerSession->getCustomerId());
            $productIds = $discountRequestCollection->getColumnValues('product_id');
            $productIds = array_unique($productIds);
            $productIds = array_values(array_map('intval', $productIds));
        } else {
            $productIds = (array) $this->customerSession->getDiscountRequestProductIds();
        }

        return [
            'name' => $name,
            'email' => $email,
            'productIds' => $productIds,
            'isLoggedIn' => $this->customerSession->isLoggedIn()
        ];
    }
}
