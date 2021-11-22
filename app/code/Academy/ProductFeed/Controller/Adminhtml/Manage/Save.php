<?php

namespace Academy\ProductFeed\Controller\Adminhtml\Manage;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;

class Save extends Action
{
    public $feedFactory;

    public function __construct(
        Context                                       $context,
        \Academy\ProductFeed\Model\ProductFeedFactory $feedFactory
    )
    {
        $this->feedFactory = $feedFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getParams();

        if (isset($data['product_feed_id']) && $data['product_feed_id']) {
            $model = $this->feedFactory->create()->load($data['product_feed_id']);
            $model->setFilename($data['filename'])
                ->setName($data['name'])
                ->setStatus($data['status'])
                ->setFileType($data['file_type'])
                ->setFtp($data['ftp'])
                ->setTemplateContent($data['template_content'])
                ->setCategories(implode(",", $data['categories']))
                ->setUpdatedAt(date("Y-m-d H:i:s"))
                ->save();
            $this->messageManager->addSuccess(__('You have updated the product feed successfully.'));
        } else {
            $model = $this->feedFactory->create();
            $model->setFilename($data['filename'])
                ->setName($data['name'])
                ->setStatus($data['status'])
                ->setFileType($data['file_type'])
                ->setFtp($data['ftp'])
                ->setTemplateContent($data['template_content'])
                ->setCategories(implode(",", $data['categories']))
                ->setUpdatedAt(date("Y-m-d H:i:s"))
                ->setCreatedAt(date("Y-m-d H:i:s"))
                ->save();
            $this->messageManager->addSuccess(__('You have successfully created the product feed.'));
        }
        return $resultRedirect->setPath('*/*/index');

    }

    public function _isAllowed()
    {
        return $this->_authorization->isAllowed('Academy_ProductFeed::save');
    }
}
