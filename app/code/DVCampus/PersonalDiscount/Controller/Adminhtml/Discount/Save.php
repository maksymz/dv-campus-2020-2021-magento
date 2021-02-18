<?php

declare(strict_types=1);

namespace DVCampus\PersonalDiscount\Controller\Adminhtml\Discount;

use DVCampus\PersonalDiscount\Model\Authorization;
use Magento\Framework\Controller\ResultInterface;

class Save extends \Magento\Backend\App\Action implements \Magento\Framework\App\Action\HttpPostActionInterface
{
    public const ADMIN_RESOURCE = Authorization::ACTION_DISCOUNT_REQUEST_EDIT;

    /**
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        // @TODO: save request if changed

        return $resultRedirect->setPath(
            '*/*/edit',
            [
                'discount_request_id' => $this->getRequest()->getParam('discount_request_id')
            ]
        );
    }
}
