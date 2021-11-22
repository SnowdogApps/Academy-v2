<?php

namespace Academy\ProductFeed\Controller\Adminhtml\Manage;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Action\HttpGetActionInterface;

class Add extends Action implements HttpGetActionInterface
{
    protected $pageFactory;

    public function __construct(
        Context     $context,
        PageFactory $rawFactory
    )
    {
        $this->pageFactory = $rawFactory;
        parent::__construct($context);
    }


    public function execute()
    {
        $this->_forward('edit');
    }

    public function _isAllowed()
    {
        return $this->_authorization->isAllowed('Academy_ProductFeed::add');
    }

}
