<?php
declare(strict_types=1);

namespace Academy\ProductFeed\Ui\DataProvider\ProductFeed\Listing;

use Magento\Framework\View\Element\UiComponent\DataProvider\SearchResult;

class Collection extends SearchResult
{
    protected function _initSelect(): void
    {
        parent::_initSelect();
        $this->addFilterToMap('product_feed_id', 'main_table.product_feed_id');
    }
}
