<?php

declare(strict_types=1);

namespace DVCampus\PersonalDiscount\Controller\Adminhtml\Discount;

use DVCampus\PersonalDiscount\Model\Authorization;
use DVCampus\PersonalDiscount\Model\DiscountRequest;
use Magento\Framework\Controller\ResultInterface;

class Save extends \Magento\Backend\App\Action implements \Magento\Framework\App\Action\HttpPostActionInterface
{
    public const ADMIN_RESOURCE = Authorization::ACTION_DISCOUNT_REQUEST_EDIT;

    private \DVCampus\PersonalDiscount\Model\DiscountRequestFactory $discountRequestFactory;

    private \DVCampus\PersonalDiscount\Model\ResourceModel\DiscountRequest $discountRequestResource;

    private \Magento\Catalog\Model\ProductRepository $productRepository;

    private \Magento\Customer\Model\ResourceModel\CustomerRepository $customerRepository;

    private \DVCampus\PersonalDiscount\Model\Email $email;

    private \Magento\Store\Model\StoreManager $storeManager;

    /**
     * Save constructor.
     * @param \DVCampus\PersonalDiscount\Model\DiscountRequestFactory $discountRequestFactory
     * @param \DVCampus\PersonalDiscount\Model\ResourceModel\DiscountRequest $discountRequestResource
     * @param \DVCampus\PersonalDiscount\Model\Email $email
     * @param \Magento\Catalog\Model\ProductRepository $productRepository
     * @param \Magento\Customer\Model\ResourceModel\CustomerRepository $customerRepository
     * @param \Magento\Store\Model\StoreManager $storeManager
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
        \DVCampus\PersonalDiscount\Model\DiscountRequestFactory $discountRequestFactory,
        \DVCampus\PersonalDiscount\Model\ResourceModel\DiscountRequest $discountRequestResource,
        \DVCampus\PersonalDiscount\Model\Email $email,
        \Magento\Catalog\Model\ProductRepository $productRepository,
        \Magento\Customer\Model\ResourceModel\CustomerRepository $customerRepository,
        \Magento\Store\Model\StoreManager $storeManager,
        \Magento\Backend\App\Action\Context $context
    ) {
        parent::__construct($context);
        $this->discountRequestFactory = $discountRequestFactory;
        $this->discountRequestResource = $discountRequestResource;
        $this->productRepository = $productRepository;
        $this->customerRepository = $customerRepository;
        $this->email = $email;
        $this->storeManager = $storeManager;
    }

    /**
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $request = $this->getRequest();

        $discountRequest = $this->discountRequestFactory->create();
        $this->discountRequestResource->load($discountRequest, $request->getParam('discount_request_id'));

        if (!$discountRequest->getId()) {
            $this->messageManager->addErrorMessage(__('This request no longer exists.'));

            return $resultRedirect->setPath('*/*/');
        }

        // This is actually wrong and we ,must save Store ID because product may have different names in different stores!
        // @TODO: migrate data to the `store_id` column, fill it with the default store id
        $storeId = (int) $this->storeManager->getWebsite($discountRequest->getWebsiteId())->getDefaultStore()->getId();
        $productName = $this->productRepository->getById($discountRequest->getProductId(), false, $storeId)->getName();

        $customerEmail = $discountRequest->getCustomerId()
            ? $this->customerRepository->getById($discountRequest->getCustomerId())->getEmail()
            : $discountRequest->getEmail();

        // @TODO: save request if changed

        if ($request->getParam('notify')) {
            switch ($discountRequest->getStatus()) {
                case DiscountRequest::STATUS_APPROVED:
                    $this->email->sendRequestApprovedEmail($customerEmail, $productName, $storeId);
                    break;
                case DiscountRequest::STATUS_DECLINED:
                    $this->email->sendRequestDeclinedEmail($customerEmail, $productName, $storeId);
                    break;
                default:
                    break;
            }
        }

        return $resultRedirect->setPath(
            '*/*/edit',
            [
                'discount_request_id' => $this->getRequest()->getParam('discount_request_id')
            ]
        );
    }
}
