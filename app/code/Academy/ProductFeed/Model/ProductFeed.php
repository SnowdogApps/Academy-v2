<?php
declare(strict_types=1);

namespace Academy\ProductFeed\Model;

use Magento\Framework\Model\AbstractModel;

class ProductFeed extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(ResourceModel\ProductFeed::class);
    }

    public function getProductFeedId(): int
    {
        return (int) $this->getData('product_feed_id');
    }
}

