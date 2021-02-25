<?php

declare(strict_types=1);

namespace DVCampus\PersonalDiscount\Model;

use Magento\Framework\App\Area;

class Email
{
    private \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder;

    private \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation;

    private \Magento\Store\Model\StoreManagerInterface $storeManager;

    private \DVCampus\PersonalDiscount\Model\Config $config;

    private \Psr\Log\LoggerInterface $logger;

    /**
     * @param \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder
     * @param \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \DVCampus\PersonalDiscount\Model\Config $config
     * @param \Psr\Log\LoggerInterface $logger $logger
     */
    public function __construct(
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
        \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \DVCampus\PersonalDiscount\Model\Config $config,
        \Psr\Log\LoggerInterface $logger
    ) {
        $this->transportBuilder = $transportBuilder;
        $this->inlineTranslation = $inlineTranslation;
        $this->storeManager = $storeManager;
        $this->config = $config;
        $this->logger = $logger;
    }

    /**
     * @param string $customerName
     * @param string $customerEmail
     * @param string $productName
     * @return bool
     */
    public function sendNewDiscountRequestEmail(
        string $customerName,
        string $customerEmail,
        string $productName
    ): bool {
        $templateVariables = [
            'customer_name' => $customerName,
            'product_name' => $productName
        ];

        return $this->send($customerEmail, 'dv_campus_new_discount_request', $templateVariables);
    }

    /**
     * @param string $customerEmail
     * @param string $productName
     * @param int $storeId
     * @return bool
     */
    public function sendRequestApprovedEmail(string $customerEmail, string $productName, int $storeId): bool
    {
        $templateVariables = [
            'product_name' => $productName
        ];

        return $this->send($customerEmail, 'dv_campus_discount_request_approved', $templateVariables, $storeId);
    }

    /**
     * @param string $customerEmail
     * @param string $productName
     * @param int $storeId
     * @return bool
     */
    public function sendRequestDeclinedEmail(string $customerEmail, string $productName, int $storeId): bool
    {
        $templateVariables = [
            'product_name' => $productName
        ];

        return $this->send($customerEmail, 'dv_campus_discount_request_declined', $templateVariables, $storeId);
    }

    /**
     * @param string $recipientEmail
     * @param string $templateId
     * @param array $templateVariables
     * @param int $storeId
     * @return bool
     */
    public function send(string $recipientEmail, string $templateId, array $templateVariables, int $storeId = 0): bool
    {
        $this->inlineTranslation->suspend();

        try {
            $transport = $this->transportBuilder
                ->setTemplateIdentifier($templateId)
                ->setTemplateOptions(
                    [
                        'area' => Area::AREA_FRONTEND,
                        'store' => $storeId ?: $this->storeManager->getStore()->getId()
                    ]
                )
                ->setFromByScope($this->config->getSenderEmailIdentity(), $storeId ?: null)
                ->setTemplateVars($templateVariables)
                ->addTo($recipientEmail)
                ->getTransport();

            $transport->sendMessage();
        } catch (\Exception $e) {
            $this->logger->critical($e->getMessage());

            return false;
        } finally {
            $this->inlineTranslation->resume();
        }

        return true;
    }
}
