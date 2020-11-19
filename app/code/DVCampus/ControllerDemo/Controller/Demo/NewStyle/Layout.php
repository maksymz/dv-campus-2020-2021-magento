<?php
declare(strict_types=1);

namespace DVCampus\ControllerDemo\Controller\Demo\NewStyle;

use Magento\Framework\View\Result\Layout as LayoutResponse;

class Layout implements \Magento\Framework\App\Action\HttpGetActionInterface
{
    /**
     * @var \Magento\Framework\View\Result\LayoutFactory $layoutResponseFactory
     */
    private $layoutResponseFactory;

    /**
     * Controller constructor.
     * @param \Magento\Framework\View\Result\LayoutFactory $layoutResponseFactory
     */
    public function __construct(
        \Magento\Framework\View\Result\LayoutFactory $layoutResponseFactory
    ) {
        $this->layoutResponseFactory = $layoutResponseFactory;
    }

    /**
     * https://maksym-zaporozhets-dev.local/dv-campus-2020-2021/demo_newStyle/layoutController
     * Layout file name: dvcampus_controller_demo_demo_newstyle_layout.xml
     *
     * @return LayoutResponse
     */
    public function execute(): LayoutResponse
    {
        return $this->layoutResponseFactory->create();
    }
}
