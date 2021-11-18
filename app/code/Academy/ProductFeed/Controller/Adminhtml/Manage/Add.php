<?php

namespace Academy\ProductFeed\Controller\Adminhtml\Manage;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Action\HttpGetActionInterface;

class Add extends Action implements HttpGetActionInterface
{
    const MENU_ID = 'Academy_ProductFeed::manage_feeds';

    protected $pageFactory;

    public function __construct(
        Context $context,
        PageFactory $rawFactory
    ) {
        $this->pageFactory = $rawFactory;

        parent::__construct($context);
    }


    public function execute()
    {
        $resultPage = $this->pageFactory->create();
        //$resultPage->setActiveMenu(static::MENU_ID);
        //$resultPage->getConfig()->getTitle()->prepend(__('Manage Feeds'));

        return $resultPage;
    }
}
