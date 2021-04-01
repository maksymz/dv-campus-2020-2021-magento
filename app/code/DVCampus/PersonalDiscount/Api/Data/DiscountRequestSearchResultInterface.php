<?php

declare(strict_types=1);

namespace DVCampus\PersonalDiscount\Api\Data;

/**
 * Interface DiscountRequestSearchResultInterface
 * A list of Discount Requests and their associated data filtered by SearchCriteria
 *
 * @api
 */
interface DiscountRequestSearchResultInterface extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * @return \DVCampus\PersonalDiscount\Api\Data\DiscountRequestInterface[]
     */
    public function getItems();

    /**
     * @param \DVCampus\PersonalDiscount\Api\Data\DiscountRequestInterface[] $items
     * @return $this
     */
    public function setItems(array $items = null);
}
