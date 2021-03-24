<?php

declare(strict_types=1);

namespace DVCampus\ObserversAndPlugins\Observer;

use Magento\Framework\Event\Observer;

class ModifyFooParameter implements \Magento\Framework\Event\ObserverInterface
{
    public function execute(Observer $observer)
    {
        $transport = $observer->getData('transport');
        $transport->setData('foo', $transport->getData('foo') . ' dolor sit amet');
    }
}
