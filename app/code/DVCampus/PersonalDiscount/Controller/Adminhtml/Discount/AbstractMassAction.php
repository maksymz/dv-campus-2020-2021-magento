<?php

declare(strict_types=1);

namespace DVCampus\PersonalDiscount\Controller\Adminhtml\Discount;

abstract class AbstractMassAction extends \Magento\Backend\App\Action
{
    protected \Magento\Ui\Component\MassAction\Filter $filter;

    protected \DVCampus\PersonalDiscount\Model\ResourceModel\DiscountRequest\CollectionFactory
        $discountRequestCollectionFactory;

    protected \Magento\Framework\DB\TransactionFactory $transactionFactory;

    /**
     * Delete constructor.
     * @param \Magento\Ui\Component\MassAction\Filter $filter
     * @param \DVCampus\PersonalDiscount\Model\ResourceModel\DiscountRequest\CollectionFactory
     *     $discountRequestCollectionFactory
     * @param \Magento\Framework\DB\TransactionFactory $transaction
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
        \Magento\Ui\Component\MassAction\Filter $filter,
        \DVCampus\PersonalDiscount\Model\ResourceModel\DiscountRequest\CollectionFactory
        $discountRequestCollectionFactory,
        \Magento\Framework\DB\TransactionFactory $transaction,
        \Magento\Backend\App\Action\Context $context
    ) {
        $this->filter = $filter;
        $this->discountRequestCollectionFactory = $discountRequestCollectionFactory;
        $this->transactionFactory = $transaction;
        parent::__construct($context);
    }
}
