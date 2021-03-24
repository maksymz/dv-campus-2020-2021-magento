<?php

declare(strict_types=1);

namespace DVCampus\ObserversAndPlugins\Observer;

use Magento\Framework\Event\Observer;

class CatalogProductViewPredispatch implements \Magento\Framework\Event\ObserverInterface
{
    public function execute(Observer $observer)
    {
        $controller = $observer->getEvent()->getData('controller_action');
        $controller = $observer->getData('controller_action');
        $controller = $observer->getControllerAction();
    }
}
