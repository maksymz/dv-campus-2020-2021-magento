<?php

declare(strict_types=1);

namespace DVCampus\PersonalDiscount\Model;

use DVCampus\PersonalDiscount\Api\Data\DiscountRequestSearchResultInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

/**
 * Class DiscountRequestRepository
 * @api
 */
class DiscountRequestRepository implements \DVCampus\PersonalDiscount\Api\DiscountRequestRepositoryInterface
{
    private \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface $collectionProcessor;

    private \DVCampus\PersonalDiscount\Model\ResourceModel\DiscountRequest\CollectionFactory $discountRequestCollectionFactory;

    private \DVCampus\PersonalDiscount\Model\Api\Data\DiscountRequestSearchResultFactory $discountRequestSearchResultFactory;

    /**
     * DiscountRequestRepository constructor.
     * @param \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface $collectionProcessor
     * @param \DVCampus\PersonalDiscount\Model\ResourceModel\DiscountRequest\CollectionFactory $discountRequestCollectionFactory
     * @param \DVCampus\PersonalDiscount\Model\Api\Data\DiscountRequestSearchResultFactory $discountRequestSearchResultFactory
     */
    public function __construct(
        \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface $collectionProcessor,
        \DVCampus\PersonalDiscount\Model\ResourceModel\DiscountRequest\CollectionFactory $discountRequestCollectionFactory,
        \DVCampus\PersonalDiscount\Model\Api\Data\DiscountRequestSearchResultFactory $discountRequestSearchResultFactory
    ) {
        $this->collectionProcessor = $collectionProcessor;
        $this->discountRequestCollectionFactory = $discountRequestCollectionFactory;
        $this->discountRequestSearchResultFactory = $discountRequestSearchResultFactory;
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return DiscountRequestSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): DiscountRequestSearchResultInterface
    {
        $discountRequestCollection = $this->discountRequestCollectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $discountRequestCollection);

        return $this->discountRequestSearchResultFactory->create()
            ->setItems($discountRequestCollection->getItems())
            ->setSearchCriteria($searchCriteria)
            ->setTotalCount($discountRequestCollection->getSize());
    }
}
