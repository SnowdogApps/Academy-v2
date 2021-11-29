<?php
declare(strict_types=1);

namespace Academy\ProductFeed\Model;

use Exception;
use Academy\ProductFeed\Model\ResourceModel\ProductFeed as ProductFeedResource;
use Magento\Framework\Message\Manager;

class ProductFeedManager
{
    protected ProductFeedResource $productFeedResource;
    protected Manager $messageManager;

    public function __construct(
        ProductFeedResource $productFeedResource,
        Manager             $messageManager
    )
    {
        $this->productFeedResource = $productFeedResource;
        $this->messageManager = $messageManager;
    }

    /**
     * @throws \Exception
     */
    public function deleteProductFeed(ProductFeed $productFeed): void
    {
        $this->productFeedResource->delete($productFeed);
    }

    /**
     * @param ProductFeed $productFeed
     * @param $data
     */
    public function prepareDataToSave(ProductFeed $productFeed, $data): void
    {
        $productFeed->setFilename($data['general']['filename'])
            ->setName($data['general']['name'])
            ->setStatus($data['general']['status'])
            ->setFileType($data['template']['file_type'])
            ->setFtp($data['ftp']['ftp'])
            ->setTemplateContent($data['template']['template_content'])
            ->setCategories(implode(",", $data['filter']['categories']))
            ->setUpdatedAt(date("Y-m-d H:i:s"))
            ->setCreatedAt(date("Y-m-d H:i:s"));
    }

    /**
     * @param ProductFeed $productFeed
     */
    public function saveProductFeed(ProductFeed $productFeed): void
    {
        try {
            $this->productFeedResource->save($productFeed);
            $this->messageManager->addSuccessMessage('Product Feed saved!');
        } catch (Exception $e) {
            $this->messageManager->addErrorMessage('Error while saving new Product Feed!');
        }
    }
}
