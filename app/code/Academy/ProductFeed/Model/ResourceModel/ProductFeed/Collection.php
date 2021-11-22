<?php
declare(strict_types=1);

namespace Academy\ProductFeed\Model\ResourceModel\ProductFeed;

use Academy\ProductFeed\Model\ProductFeed;
use Academy\ProductFeed\Model\ResourceModel\ProductFeed as ProductFeedResource;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'product_feed_id';

    protected function _construct()
    {
        $this->_init(
            ProductFeed::class,
            ProductFeedResource::class
        );
    }
}
