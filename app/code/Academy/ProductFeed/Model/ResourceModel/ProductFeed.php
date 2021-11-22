<?php
declare(strict_types=1);

namespace Academy\ProductFeed\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class ProductFeed extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('product_feed', 'product_feed_id');
    }
}
