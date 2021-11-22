<?php

namespace Academy\ProductFeed\Controller\Adminhtml\Manage;

use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultFactory;

class Edit extends Action
{
    public function __construct(
        \Magento\Backend\App\Action\Context           $context,
        \Magento\Framework\Registry                   $coreRegistry,
        \Academy\ProductFeed\Model\ProductFeedFactory $feedFactory
    )
    {
        parent::__construct($context);
        $this->coreRegistry = $coreRegistry;
        $this->feedFactory = $feedFactory;
    }

    public function execute()
    {
        $feedId = $this->getRequest()->getParam('id');
        $feedModel = $this->feedFactory->create()->load($feedId);
        $this->coreRegistry->register('feed_data', $feedModel);
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->getConfig()->getTitle()->prepend(__("Edit Product Feed"));
        return $resultPage;
    }

    public function _isAllowed()
    {
        return $this->_authorization->isAllowed('Academy_ProductFeed::edit');
    }
}
