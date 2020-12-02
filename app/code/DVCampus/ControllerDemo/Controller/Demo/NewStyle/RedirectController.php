<?php
declare(strict_types=1);

namespace DVCampus\ControllerDemo\Controller\Demo\NewStyle;

use Magento\Framework\Controller\Result\Redirect as RedirectResponse;

class RedirectController implements \Magento\Framework\App\Action\HttpGetActionInterface
{
    /**
     * @var \Magento\Framework\App\RequestInterface $request
     */
    private $request;

    /**
     * @var \Magento\Framework\Controller\Result\RedirectFactory $redirectResponseFactory
     */
    private $redirectResponseFactory;

    /**
     * Controller constructor.
     * @param \Magento\Framework\App\RequestInterface $request
     * @param \Magento\Framework\Controller\Result\RedirectFactory $redirectResponseFactory
     */
    public function __construct(
        \Magento\Framework\App\RequestInterface $request,
        \Magento\Framework\Controller\Result\RedirectFactory $redirectResponseFactory
    ) {
        $this->request = $request;
        $this->redirectResponseFactory = $redirectResponseFactory;
    }

    /**
     * https://maksym-zaporozhets-dev.local/dv-campus-2020-2021/demo_newStyle/redirectController
     *
     * @return RedirectResponse
     */
    public function execute(): RedirectResponse
    {
        return $this->redirectResponseFactory->create()
            ->setPath(
                '*/*/jsonController',
                [
                    '_secure' => true,
                    'string_parameter' => 'some_test_string',
                    'int' => 10
                ]
            );
    }
}
