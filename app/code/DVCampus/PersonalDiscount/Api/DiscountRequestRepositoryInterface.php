<?php

declare(strict_types=1);

namespace DVCampus\PersonalDiscount\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

/**
 * Personal Discount Repository repository to get requests data
 *
 * @api
 */
interface DiscountRequestRepositoryInterface
{
    /**
     * Get full vehicle information by search criteria
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return \DVCampus\PersonalDiscount\Api\Data\DiscountRequestSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): \DVCampus\PersonalDiscount\Api\Data\DiscountRequestSearchResultInterface;
}
