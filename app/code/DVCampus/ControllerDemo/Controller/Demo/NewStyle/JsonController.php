<?php
declare(strict_types=1);

namespace DVCampus\ControllerDemo\Controller\Demo\NewStyle;

use Magento\Framework\Controller\Result\Json as JsonResponse;

class JsonController implements \Magento\Framework\App\Action\HttpGetActionInterface
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
     * Controller constructor.
     * @param \Magento\Framework\App\RequestInterface $request
     * @param \Magento\Framework\Controller\Result\JsonFactory $jsonResponseFactory
     */
    public function __construct(
        \Magento\Framework\App\RequestInterface $request,
        \Magento\Framework\Controller\Result\JsonFactory $jsonResponseFactory
    ) {
        $this->request = $request;
        $this->jsonResponseFactory = $jsonResponseFactory;
    }

    /**
     * https://maksym-zaporozhets-dev.local/dv-campus-2020-2021/demo_newStyle/jsonController
     *
     * @return JsonResponse
     */
    public function execute(): JsonResponse
    {
        $jsonResponse = $this->jsonResponseFactory->create();
        $jsonResponse->setData([
            'String Parameter' => $this->request->getParam('string_parameter'),
            'Integer Parameter' => $this->request->getParam('int'),
        ]);

        return $jsonResponse;
    }
}
