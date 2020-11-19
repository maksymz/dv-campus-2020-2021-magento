<?php
declare(strict_types=1);

namespace DVCampus\Catalog\ViewModel;

class Product implements \Magento\Framework\View\Element\Block\ArgumentInterface
{
    /**
     * @return string
     */
    public function getViewModelData(): string
    {
        return 'Data from ViewModel';
    }
}
