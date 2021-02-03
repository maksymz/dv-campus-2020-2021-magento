<?php

declare(strict_types=1);

namespace DVCampus\PersonalDiscount\Controller\View;

use DVCampus\PersonalDiscount\Controller\Index\Request;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Store\Model\ScopeInterface;

class Index extends \Magento\Framework\App\Action\Action implements \Magento\Framework\App\Action\HttpGetActionInterface
{
    private \Magento\Framework\View\Result\PageFactory $pageResponseFactory;

    private \Magento\Backend\Model\View\Result\ForwardFactory $forwardFactory;

    private \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig;

    private \Magento\Customer\Model\Session $customerSession;

    /**
     * Controller constructor.
     * @param \Magento\Framework\View\Result\PageFactory $pageResponseFactory
     * @param \Magento\Backend\Model\View\Result\ForwardFactory $forwardFactory
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Framework\App\Action\Context $context
     */
    public function __construct(
        \Magento\Framework\View\Result\PageFactory $pageResponseFactory,
        \Magento\Backend\Model\View\Result\ForwardFactory $forwardFactory,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\App\Action\Context $context
    ) {
        parent::__construct($context);
        $this->pageResponseFactory = $pageResponseFactory;
        $this->forwardFactory = $forwardFactory;
        $this->scopeConfig = $scopeConfig;
        $this->customerSession = $customerSession;
    }

    /**
     * Check customer authentication for some actions
     *
     * @param RequestInterface $request
     * @return ResponseInterface
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function dispatch(RequestInterface $request): ResponseInterface
    {
        if (!$this->customerSession->authenticate()) {
            $this->_actionFlag->set('', 'no-dispatch', true);
        }

        return parent::dispatch($request);
    }

    /**
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        if (!$this->scopeConfig->getValue(
            Request::XML_PATH_DV_CAMPUS_PERSONAL_DISCOUNT_GENERAL_ENABLED,
            ScopeInterface::SCOPE_WEBSITE
        )) {
            $resultForward = $this->forwardFactory->create();
            return $resultForward->forward('noroute');
        }

        return $this->pageResponseFactory->create();
    }
}
