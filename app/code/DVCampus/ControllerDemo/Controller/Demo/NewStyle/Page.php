<?php
declare(strict_types=1);

namespace DVCampus\ControllerDemo\Controller\Demo\NewStyle;

use Magento\Framework\View\Result\Page as PageResponse;

class Page implements \Magento\Framework\App\Action\HttpGetActionInterface
{
    private \Magento\Framework\View\Result\PageFactory $pageResponseFactory;

    private \Magento\Framework\Event\ManagerInterface $eventManager;

    private \Magento\Framework\App\RequestInterface $request;

    private \Magento\Framework\DataObjectFactory $dataObjectFactory;

    /**
     * Page constructor.
     * @param \Magento\Framework\View\Result\PageFactory $pageResponseFactory
     * @param \Magento\Framework\Event\ManagerInterface $eventManager
     * @param \Magento\Framework\App\RequestInterface $request
     * @param \Magento\Framework\DataObjectFactory $dataObjectFactory
     */
    public function __construct(
        \Magento\Framework\View\Result\PageFactory $pageResponseFactory,
        \Magento\Framework\Event\ManagerInterface $eventManager,
        \Magento\Framework\App\RequestInterface $request,
        \Magento\Framework\DataObjectFactory $dataObjectFactory
    ) {
        $this->pageResponseFactory = $pageResponseFactory;
        $this->eventManager = $eventManager;
        $this->request = $request;
        $this->dataObjectFactory = $dataObjectFactory;
    }

    /**
     * https://maksym-zaporozhets-dev.local/dv-campus-2020-2021/demo_newStyle/page/string_parameter/foo/
     * Page file name: dvcampus_controller_demo_demo_newstyle_page.xml
     *
     * @return PageResponse
     */
    public function execute(): PageResponse
    {
        $transport = $this->dataObjectFactory->create([
            'data' => ['foo' => 'Lorem ipsum']
        ]);
        $this->eventManager->dispatch(
            'dvcampus_controller_demo_page',
            ['transport' => $transport]
        );
        $this->request->setParam('foo', $transport->getData('foo'));
        $page = $this->pageResponseFactory->create();
        $page->getLayout()->getUpdate()->addHandle('foo_bar_baz');

        return $this->pageResponseFactory->create();
    }
}
