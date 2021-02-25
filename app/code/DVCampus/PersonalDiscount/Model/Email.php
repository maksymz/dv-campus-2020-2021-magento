<?php

declare(strict_types=1);

namespace DVCampus\PersonalDiscount\Model;

use Magento\Framework\App\Area;

class Email
{
    private \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder;

    private \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation;

    private \Magento\Store\Model\StoreManagerInterface $storeManager;

    /**
     * @param \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder
     * @param \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     */
    public function __construct(
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
        \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        $this->transportBuilder = $transportBuilder;
        $this->inlineTranslation = $inlineTranslation;
        $this->storeManager = $storeManager;
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
     * @param string $recipientEmail
     * @param string $templateId
     * @param array $templateVariables
     * @return bool
     */
    public function send(string $recipientEmail, string $templateId, array $templateVariables): bool
    {
        $this->inlineTranslation->suspend();

        try {
            $transport = $this->transportBuilder
                ->setTemplateIdentifier($templateId)
                ->setTemplateOptions(
                    [
                        'area' => Area::AREA_FRONTEND,
                        'store' => $this->storeManager->getStore()->getId()
                    ]
                )
                ->setTemplateVars($templateVariables)
                ->setFromByScope('support')
                ->addTo($recipientEmail)
                ->setReplyTo('maksimz@default-value.com', 'Maksym Zaporozhets')
                ->getTransport();

            $transport->sendMessage();
        } catch (\Exception $e) {
            return false;
        } finally {
            $this->inlineTranslation->resume();
        }

        return true;
    }
}
