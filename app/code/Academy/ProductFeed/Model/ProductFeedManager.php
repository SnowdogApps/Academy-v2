<?php
declare(strict_types=1);

namespace Academy\ProductFeed\Model;

use Academy\ProductFeed\Model\ResourceModel\ProductFeed as ProductFeedResource;

class ProductFeedManager
{
    protected ProductFeedResource $productFeedResource;

    public function __construct(
        ProductFeedResource $productFeedResource
    ) {
        $this->productFeedResource = $productFeedResource;
    }

    /**
     * @throws \Exception
     */
    public function deleteProductFeed(ProductFeed $productFeed): void
    {
        $this->productFeedResource->delete($productFeed);
    }
}
