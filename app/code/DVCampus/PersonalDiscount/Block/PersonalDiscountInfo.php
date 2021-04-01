<?php

declare(strict_types=1);

namespace DVCampus\PersonalDiscount\Block;

use DVCampus\PersonalDiscount\Api\Data\DiscountRequestInterface;
use DVCampus\PersonalDiscount\Model\DiscountRequest;
use Magento\Framework\Phrase;

class PersonalDiscountInfo extends \Magento\Framework\View\Element\Template
{
    private \DVCampus\PersonalDiscount\Model\DiscountRequestRepository $discountRequestRepository;

    private \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder;

    private \Magento\Store\Model\StoreManagerInterface $storeManager;

    private \Magento\Customer\Model\Session $customerSession;

    /**
     * PersonalDiscountInfo constructor.
     * @param \DVCampus\PersonalDiscount\Model\DiscountRequestRepository $discountRequestRepository
     * @param \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \DVCampus\PersonalDiscount\Model\DiscountRequestRepository $discountRequestRepository,
        \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\View\Element\Template\Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->discountRequestRepository = $discountRequestRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->storeManager = $storeManager;
        $this->customerSession = $customerSession;
    }

    /**
     * @return DiscountRequestInterface[]
     */
    public function getPersonalDiscounts(): array
    {
        $this->searchCriteriaBuilder->addFilter('customer_id', $this->customerSession->getCustomer()->getId());
        $this->searchCriteriaBuilder->addFilter('website_id', $this->storeManager->getStore()->getWebsiteId());
        $searchResult = $this->discountRequestRepository->getList($this->searchCriteriaBuilder->create());

        return $searchResult->getItems();
    }

    /**
     * @param DiscountRequestInterface $discountRequest
     * @return Phrase
     */
    public function getStatusMessage(DiscountRequestInterface $discountRequest): Phrase
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
