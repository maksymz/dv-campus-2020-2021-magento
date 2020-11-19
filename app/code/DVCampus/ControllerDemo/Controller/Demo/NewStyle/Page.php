<?php
declare(strict_types=1);

namespace DVCampus\ControllerDemo\Controller\Demo\NewStyle;

use Magento\Framework\View\Result\Page as PageResponse;

class Page implements \Magento\Framework\App\Action\HttpGetActionInterface
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory $pageResponseFactory
     */
    private $pageResponseFactory;

    /**
     * Controller constructor.
     * @param \Magento\Framework\View\Result\PageFactory $pageResponseFactory
     */
    public function __construct(
        \Magento\Framework\View\Result\PageFactory $pageResponseFactory
    ) {
        $this->pageResponseFactory = $pageResponseFactory;
    }

    /**
     * https://maksym-zaporozhets-dev.local/dv-campus-2020-2021/demo_newStyle/pageController
     * Page file name: dvcampus_controller_demo_demo_newstyle_page.xml
     *
     * @return PageResponse
     */
    public function execute(): PageResponse
    {
        $page = $this->pageResponseFactory->create();
        $page->getLayout()->getUpdate()->addHandle('foo_bar_baz');

        return $this->pageResponseFactory->create();
    }
}
