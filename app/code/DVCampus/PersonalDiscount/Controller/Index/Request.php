<?php

declare(strict_types=1);

namespace DVCampus\PersonalDiscount\Controller\Index;

use Magento\Framework\Controller\Result\Json as JsonResponse;
use DVCampus\PersonalDiscount\Model\DiscountRequest;

class Request implements \Magento\Framework\App\Action\HttpPostActionInterface
{
    /**
     * @var \Magento\Framework\App\RequestInterface $request
     */
    private $request;

    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory $jsonResponseFactory
     */
    private $jsonResponseFactory;

    /**
     * @var \DVCampus\PersonalDiscount\Model\DiscountRequestFactory $discountRequestFactory
     */
    private $discountRequestFactory;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface $storeManager
     */
    private $storeManager;

    /**
     * @var \DVCampus\PersonalDiscount\Model\ResourceModel\DiscountRequest $discountRequestResource
     */
    private $discountRequestResource;

    /**
     * @var \Magento\Customer\Model\Session $customerSession
     */
    private $customerSession;

    /**
     * @var \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator
     */
    private $formKeyValidator;

    /**
     * @var \Psr\Log\LoggerInterface $logger
     */
    private $logger;

    /**
     * Controller constructor.
     * @param \Magento\Framework\App\RequestInterface $request
     * @param \Magento\Framework\Controller\Result\JsonFactory $jsonResponseFactory
     * @param \DVCampus\PersonalDiscount\Model\DiscountRequestFactory $discountRequestFactory
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \DVCampus\PersonalDiscount\Model\ResourceModel\DiscountRequest $discountRequestResource
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator
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
            if (!$this->formKeyValidator->validate($this->request)) {
                throw new \InvalidArgumentException('Form key is not valid');
            }

            $customerId = $this->customerSession->getCustomerId() ? (int) $this->customerSession->getCustomerId() : null;
            /** @var DiscountRequest $discountRequest */
            $discountRequest = $this->discountRequestFactory->create();
            // @TODO: validate product ID - check that it exists
            $discountRequest->setProductId((int) $this->request->getParam('product_id'))
                ->setName($this->request->getParam('name'))
                ->setEmail($this->request->getParam('email'))
                ->setMessage($this->request->getParam('message'))
                ->setCustomerId($customerId)
                ->setWebsiteId((int) $this->storeManager->getStore()->getWebsiteId())
                ->setStatus(DiscountRequest::STATUS_PENDING);
            $this->discountRequestResource->save($discountRequest);
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
