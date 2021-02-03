<?php

declare(strict_types=1);

namespace DVCampus\PersonalDiscount\Block;

use DVCampus\PersonalDiscount\Model\DiscountRequest;
use DVCampus\PersonalDiscount\Model\ResourceModel\DiscountRequest\Collection as DiscountRequestCollection;
use Magento\Framework\Phrase;

class PersonalDiscountInfo extends \Magento\Framework\View\Element\Template
{
    private \DVCampus\PersonalDiscount\Model\ResourceModel\DiscountRequest\CollectionFactory $collectionFactory;

    private \Magento\Store\Model\StoreManagerInterface $storeManager;

    private \Magento\Customer\Model\Session $customerSession;

    /**
     * PersonalDiscountInfo constructor.
     * @param \DVCampus\PersonalDiscount\Model\ResourceModel\DiscountRequest\CollectionFactory $collectionFactory
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \DVCampus\PersonalDiscount\Model\ResourceModel\DiscountRequest\CollectionFactory $collectionFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\View\Element\Template\Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->collectionFactory = $collectionFactory;
        $this->storeManager = $storeManager;
        $this->customerSession = $customerSession;
    }

    /**
     * @return DiscountRequest|null
     */
    public function getPersonalDiscount(): ?DiscountRequest
    {
        /** @var DiscountRequestCollection $collection */
        $collection = $this->collectionFactory->create();
        $collection->addFieldToFilter('customer_id', $this->customerSession->getCustomer()->getId());
        // @TODO: check if accounts are shared and add filter if not
        $collection->addFieldToFilter('website_id', $this->storeManager->getStore()->getWebsiteId());
        /** @var DiscountRequest $discountRequest */
        $discountRequest = $collection->getFirstItem();

        return $discountRequest->getDiscountRequestId() ? $discountRequest : null;
    }

    /**
     * @param DiscountRequest $discountRequest
     * @return Phrase
     */
    public function getStatusMessage(DiscountRequest $discountRequest): Phrase
    {
        switch ($discountRequest->getStatus()) {
            case DiscountRequest::STATUS_PENDING:
                return __('pending');
            case DiscountRequest::STATUS_APPROVED:
                return __('approved');
            case DiscountRequest::STATUS_DECLINED:
            default:
                return __('declined');
        }
    }
}
