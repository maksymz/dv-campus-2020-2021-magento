<?php

declare(strict_types=1);

namespace DVCampus\PersonalDiscount\Controller\Adminhtml\Discount;

use Magento\Framework\Controller\ResultFactory;

class Index extends \Magento\Backend\App\Action
{
    public const ADMIN_RESOURCE = 'DVCampus_PersonalDiscount::listing';

    /**
     * @inheritDoc
     */
    public function execute()
    {
        return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
    }
}
