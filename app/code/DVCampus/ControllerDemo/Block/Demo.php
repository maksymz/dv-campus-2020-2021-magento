<?php
declare(strict_types=1);

namespace DVCampus\ControllerDemo\Block;

class Demo extends \Magento\Framework\View\Element\Template
{
    /**
     * @return string
     */
    public function getStringParameter(): string
    {
        return (string) $this->getRequest()->getParam('string_parameter');
    }

    /**
     * @return int
     */
    public function getIntegerParameter(): int
    {
        return (int) $this->getRequest()->getParam('int');
    }

    /**
     * @return float
     */
    public function getFloatParameter(): float
    {
        return (float) $this->getRequest()->getParam('float', 10.0);
    }
}
