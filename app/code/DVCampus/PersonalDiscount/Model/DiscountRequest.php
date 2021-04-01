<?php

declare(strict_types=1);

namespace DVCampus\PersonalDiscount\Model;

use DVCampus\PersonalDiscount\Api\Data\DiscountRequestInterface;

/**
 * Class DiscountRequest
 * @api
 */
class DiscountRequest extends \Magento\Framework\Model\AbstractModel implements
    \DVCampus\PersonalDiscount\Api\Data\DiscountRequestInterface
{
    public const STATUS_PENDING = 1;
    public const STATUS_APPROVED = 2;
    public const STATUS_DECLINED = 3;

    /**
     * @inheritDoc
     */
    protected function _construct(): void
    {
        parent::_construct();
        $this->_init(\DVCampus\PersonalDiscount\Model\ResourceModel\DiscountRequest::class);
    }

    /**
     * @return int
     */
    public function getDiscountRequestId(): int
    {
        return (int) $this->getData(DiscountRequestInterface::DISCOUNT_REQUEST_ID);
    }

    /**
     * @param int $discountRequestId
     * @return DiscountRequestInterface
     */
    public function setDiscountRequestId(int $discountRequestId): DiscountRequestInterface
    {
        return $this->setData(DiscountRequestInterface::DISCOUNT_REQUEST_ID, $discountRequestId);
    }

    /**
     * @return int|null
     */
    public function getProductId(): ?int
    {
        return ((int) $this->getData(DiscountRequestInterface::PRODUCT_ID)) ?: null;
    }

    /**
     * @param int|null $productId
     * @return DiscountRequestInterface
     */
    public function setProductId(int $productId = null): DiscountRequestInterface
    {
        return $this->setData(DiscountRequestInterface::DISCOUNT_REQUEST_ID, $productId);
    }

    /**
     * @return int|null
     */
    public function getCustomerId(): ?int
    {
        return ((int) $this->getData(DiscountRequestInterface::CUSTOMER_ID)) ?: null;
    }

    /**
     * @param int|null $customerId
     * @return DiscountRequestInterface
     */
    public function setCustomerId(int $customerId = null): DiscountRequestInterface
    {
        return $this->setData(DiscountRequestInterface::CUSTOMER_ID, $customerId);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return (string) $this->getData(DiscountRequestInterface::NAME);
    }

    /**
     * @param string $name
     * @return DiscountRequestInterface
     */
    public function setName(string $name): DiscountRequestInterface
    {
        return $this->setData(DiscountRequestInterface::NAME, $name);
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return (string) $this->getData(DiscountRequestInterface::EMAIL);
    }

    /**
     * @param string $email
     * @return DiscountRequestInterface
     */
    public function setEmail(string $email): DiscountRequestInterface
    {
        return $this->setData(DiscountRequestInterface::EMAIL, $email);
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return (string) $this->getData(DiscountRequestInterface::MESSAGE);
    }

    /**
     * @param string $message
     * @return DiscountRequestInterface
     */
    public function setMessage(string $message): DiscountRequestInterface
    {
        return $this->setData(DiscountRequestInterface::MESSAGE, $message);
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return (int) $this->getData(DiscountRequestInterface::STATUS);
    }

    /**
     * @param int $status
     * @return DiscountRequestInterface
     */
    public function setStatus(int $status): DiscountRequestInterface
    {
        return $this->setData(DiscountRequestInterface::STATUS, $status);
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return (string) $this->getData(DiscountRequestInterface::CREATED_AT);
    }

    /**
     * @param string $createdAt
     * @return DiscountRequestInterface
     */
    public function setCreatedAt(string $createdAt): DiscountRequestInterface
    {
        return $this->setData(DiscountRequestInterface::CREATED_AT, $createdAt);
    }

    /**
     * @return string
     */
    public function getUpdatedAt(): string
    {
        return (string) $this->getData(DiscountRequestInterface::UPDATED_AT);
    }

    /**
     * @param string $updatedAt
     * @return DiscountRequestInterface
     */
    public function setUpdatedAt(string $updatedAt): DiscountRequestInterface
    {
        return $this->setData(DiscountRequestInterface::UPDATED_AT, $updatedAt);
    }
}
