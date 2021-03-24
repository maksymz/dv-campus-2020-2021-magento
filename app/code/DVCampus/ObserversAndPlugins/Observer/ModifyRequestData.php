<?php

declare(strict_types=1);

namespace DVCampus\ObserversAndPlugins\Observer;

use Magento\Framework\Event\Observer;

class ModifyRequestData implements \Magento\Framework\Event\ObserverInterface
{
    public function execute(Observer $observer)
    {
        $request = $observer->getData('request');
        $request->setParam(
            'string_parameter',
            $request->getParam('string_parameter') ?? 'default string'
        );
    }
}
