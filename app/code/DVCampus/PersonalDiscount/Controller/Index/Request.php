<?php

declare(strict_types=1);

namespace DVCampus\PersonalDiscount\Controller\Index;

use DVCampus\PersonalDiscount\Model\DiscountRequest;
use Magento\Framework\Controller\Result\Json as JsonResponse;

class Request implements \Magento\Framework\App\Action\HttpPostActionInterface
{
    private \Magento\Framework\App\RequestInterface $request;

    private \Magento\Framework\Controller\Result\JsonFactory $jsonResponseFactory;

    private \DVCampus\PersonalDiscount\Model\DiscountRequestFactory $discountRequestFactory;

    private \Magento\Store\Model\StoreManagerInterface $storeManager;

    private \DVCampus\PersonalDiscount\Model\ResourceModel\DiscountRequest $discountRequestResource;

    private \Magento\Customer\Model\Session $customerSession;

    private \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator;

    private \DVCampus\PersonalDiscount\Helper\Config $configHelper;

    private \Psr\Log\LoggerInterface $logger;

    /**
     * Controller constructor.
     * @param \Magento\Framework\App\RequestInterface $request
     * @param \Magento\Framework\Controller\Result\JsonFactory $jsonResponseFactory
     * @param \DVCampus\PersonalDiscount\Model\DiscountRequestFactory $discountRequestFactory
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \DVCampus\PersonalDiscount\Model\ResourceModel\DiscountRequest $discountRequestResource
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator
     * @param \DVCampus\PersonalDiscount\Helper\Config $configHelper
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(
        \Magento\Framework\App\RequestInterface $request,
        \Magento\Framework\Controller\Result\JsonFactory $jsonResponseFactory,
        \DVCampus\PersonalDiscount\Model\DiscountRequestFactory $discountRequestFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \DVCampus\PersonalDiscount\Model\ResourceModel\DiscountRequest $discountRequestResource,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator,
        \DVCampus\PersonalDiscount\Helper\Config $configHelper,
        \Psr\Log\LoggerInterface $logger
    ) {
        $this->request = $request;
        $this->jsonResponseFactory = $jsonResponseFactory;
        $this->discountRequestFactory = $discountRequestFactory;
        $this->storeManager = $storeManager;
        $this->discountRequestResource = $discountRequestResource;
        $this->customerSession = $customerSession;
        $this->logger = $logger;
        $this->formKeyValidator = $formKeyValidator;
        $this->configHelper = $configHelper;
    }

    /**
     * https://maksym-zaporozhets-dev.local/dvcampus_personal_discount/index/request
     *
     * @return JsonResponse
     */
    public function execute(): JsonResponse
    {
        $response = $this->jsonResponseFactory->create();
        // @TODO: pass message via notifications, not alert
        // @TODO: add Google Recaptcha to the form
        $formSaved = false;

        try {
            if (!$this->configHelper->enabled()) {
                throw new \BadMethodCallException('Personal Discount requested, but the request can\'t be handled');
            }

            if (!$this->customerSession->isLoggedIn()
                && !$this->configHelper->allowForGuests()
            ) {
                throw new \BadMethodCallException('Personal Discount requested, but the request can\'t be handled');
            }

            if (!$this->formKeyValidator->validate($this->request)) {
                throw new \InvalidArgumentException('Form key is not valid');
            }

            $customerId = $this->customerSession->getCustomerId()
                ? (int) $this->customerSession->getCustomerId()
                : null;

            if ($this->customerSession->isLoggedIn()) {
                $name = $this->customerSession->getCustomer()->getName();
                $email = $this->customerSession->getCustomer()->getEmail();
            } else {
                $name = $this->request->getParam('name');
                $email = $this->request->getParam('email');
            }

            // @TODO: validate product ID - check that it exists
            $productId = (int) $this->request->getParam('product_id');
            /** @var DiscountRequest $discountRequest */
            $discountRequest = $this->discountRequestFactory->create();
            $discountRequest->setProductId($productId)
                ->setName($name)
                ->setEmail($email)
                ->setMessage($this->request->getParam('message'))
                ->setCustomerId($customerId)
                ->setWebsiteId((int) $this->storeManager->getStore()->getWebsiteId())
                ->setStatus(DiscountRequest::STATUS_PENDING);
            $this->discountRequestResource->save($discountRequest);

            if (!$this->customerSession->isLoggedIn()) {
                $this->customerSession->setDiscountRequestCustomerName($this->request->getParam('name'));
                $this->customerSession->setDiscountRequestCustomerEmail($this->request->getParam('email'));
                $productIds = $this->customerSession->getDiscountRequestProductIds() ?? [];
                $productIds[] = $productId;
                $this->customerSession->setDiscountRequestProductIds(array_unique($productIds));
            }

            $formSaved = true;
        } catch (\InvalidArgumentException $e) {
            // No need to log form key validation errors
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
        }

        $message = $formSaved
            ? __('You request for product %1 was accepted!', $this->request->getParam('productName'))
            : __('Your request can\'t be sent. Please, contact us if you see this message.');

        return $response->setData([
            'message' => $message
        ]);
    }
}
