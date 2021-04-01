<?php

declare(strict_types=1);

namespace DVCampus\PersonalDiscount\Api\Data;

/**
 * Interface DiscountRequestInterface
 * @api
 */
interface DiscountRequestInterface
{
    public const DISCOUNT_REQUEST_ID = 'discount_request_id';
    public const PRODUCT_ID = 'product_id';
    public const CUSTOMER_ID = 'customer_id';
    public const NAME = 'name';
    public const EMAIL = 'email';
    public const MESSAGE = 'message';
    public const WEBSITE_ID = 'website_id';
    public const STATUS = 'status';
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';

    /**
     * @return int
     */
    public function getDiscountRequestId(): int;

    /**
     * @param int $discountRequestId
     * @return DiscountRequestInterface
     */
    public function setDiscountRequestId(int $discountRequestId): DiscountRequestInterface;

    /**
     * @return int|null
     */
    public function getProductId(): ?int;

    /**
     * @param int|null $productId
     * @return DiscountRequestInterface
     */
    public function setProductId(int $productId = null): DiscountRequestInterface;

    /**
     * @return int|null
     */
    public function getCustomerId(): ?int;

    /**
     * @param int|null $customerId
     * @return DiscountRequestInterface
     */
    public function setCustomerId(int $customerId = null): DiscountRequestInterface;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @param string $name
     * @return DiscountRequestInterface
     */
    public function setName(string $name): DiscountRequestInterface;

    /**
     * @return string
     */
    public function getEmail(): string;

    /**
     * @param string $email
     * @return DiscountRequestInterface
     */
    public function setEmail(string $email): DiscountRequestInterface;

    /**
     * @return string
     */
    public function getMessage(): string;

    /**
     * @param string $message
     * @return DiscountRequestInterface
     */
    public function setMessage(string $message): DiscountRequestInterface;

    /**
     * @return int
     */
    public function getStatus(): int;

    /**
     * @param int $status
     * @return DiscountRequestInterface
     */
    public function setStatus(int $status): DiscountRequestInterface;

    /**
     * @return string
     */
    public function getCreatedAt(): string;

    /**
     * @param string $createdAt
     * @return DiscountRequestInterface
     */
    public function setCreatedAt(string $createdAt): DiscountRequestInterface;

    /**
     * @return string
     */
    public function getUpdatedAt(): string;

    /**
     * @param string $updatedAt
     * @return DiscountRequestInterface
     */
    public function setUpdatedAt(string $updatedAt): DiscountRequestInterface;
}
