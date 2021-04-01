<?php

declare(strict_types=1);

namespace DVCampus\PersonalDiscount\Api;

use DVCampus\PersonalDiscount\Api\Data\DiscountRequestSearchResultInterface;
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
     * @return DiscountRequestSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): DiscountRequestSearchResultInterface;
}
