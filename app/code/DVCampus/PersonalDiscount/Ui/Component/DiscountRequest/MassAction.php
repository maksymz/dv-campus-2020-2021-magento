<?php

declare(strict_types=1);

namespace DVCampus\PersonalDiscount\Ui\Component\DiscountRequest;

use Magento\Framework\View\Element\UiComponentInterface;

/**
 * Based on \Magento\Catalog\Ui\Component\Product\MassAction
 */
class MassAction extends \Magento\Catalog\Ui\Component\Product\MassAction
{
    private \Magento\Framework\AuthorizationInterface $authorization;

    /**
     * Constructor
     *
     * @param \Magento\Framework\AuthorizationInterface $authorization
     * @param \Magento\Framework\View\Element\UiComponent\ContextInterface $context
     * @param UiComponentInterface[] $components
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\AuthorizationInterface $authorization,
        \Magento\Framework\View\Element\UiComponent\ContextInterface $context,
        array $components = [],
        array $data = []
    ) {
        $this->authorization = $authorization;
        parent::__construct($authorization, $context, $components, $data);
    }

    /**
     * @inheritdoc
     */
    public function getComponentName(): string
    {
        return 'massaction';
    }

    /**
     * Check if the given type of action is allowed
     *
     * @param string $actionType
     * @return bool
     */
    public function isActionAllowed($actionType): bool
    {
        $isAllowed = true;

        switch ($actionType) {
            case 'delete':
                $isAllowed = $this->authorization->isAllowed('DVCampus_PersonalDiscount::delete');
                break;
            case 'status':
                $isAllowed = $this->authorization->isAllowed('DVCampus_PersonalDiscount::edit');
                break;
            default:
                break;
        }

        return $isAllowed;
    }
}
