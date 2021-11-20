<?php
declare(strict_types=1);

namespace Academy\ProductFeed\Controller\Adminhtml\Manage;

use Academy\ProductFeed\Model\ProductFeedManager;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\NotFoundException;
use Magento\Ui\Component\MassAction\Filter;
use Academy\ProductFeed\Model\ResourceModel\ProductFeed\CollectionFactory;

class MassDelete extends Action implements HttpPostActionInterface
{
    protected CollectionFactory $collectionFactory;

    protected Filter $filter;
    private ProductFeedManager $productFeedManager;

    public function __construct(
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory,
        ProductFeedManager $productFeedManager
    ) {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->productFeedManager = $productFeedManager;
        parent::__construct($context);
    }

    public function execute(): Redirect
    {
        if (!$this->getRequest()->isPost()) {
            throw new NotFoundException(__('Page not found'));
        }
        $collection = $this->filter->getCollection($this->collectionFactory->create());

        $productFeedDeleted = 0;

        foreach ($collection->getItems() as $productFeed) {
            try {
                $this->productFeedManager->deleteProductFeed($productFeed);
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(
                    __('Could not delete product feed with id %1', $productFeed->getProductFeedId())
                );
            }
            $productFeedDeleted++;
        }

        if ($productFeedDeleted) {
            $this->messageManager->addSuccessMessage(
                __('A total of %1 record(s) have been deleted.', $productFeedDeleted)
            );
        }
        return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setPath('product_feed/manage/index');
    }
}
