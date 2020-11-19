<?php
declare(strict_types=1);

namespace DVCampus\ControllerDemo\Controller\Demo;

class OldStyleController extends \Magento\Framework\App\Action\Action
{
    /**
     * https://maksym-zaporozhets-dev.local/dv-campus-2020-2021/demo/oldStyleController
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|void
     */
    public function execute()
    {
        echo '123';
        exit;
    }
}
