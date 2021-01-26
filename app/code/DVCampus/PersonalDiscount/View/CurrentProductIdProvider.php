<?php

declare(strict_types=1);

namespace DVCampus\PersonalDiscount\View;

class CurrentProductIdProvider implements \Magento\Framework\View\Layout\Argument\UpdaterInterface
{
    private \Magento\Framework\Registry $registry;

    /**
     * CurrentProduct constructor.
     * @param \Magento\Framework\Registry $registry
     */
    public function __construct(
        \Magento\Framework\Registry $registry
    ) {
        $this->registry = $registry;
    }

    /**
     * @inheritdoc
     */
    public function update($argument)
    {
        $argument['components']['personalDiscountRequestButton']['productId']
            = (int) $this->registry->registry('product')->getId();

        return $argument;
    }
}
