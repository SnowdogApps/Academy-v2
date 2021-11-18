<?php

namespace Academy\ProductFeed\Controller\Adminhtml\Manage;

use Academy\ProductFeed\Logger\Logger;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\ActionInterface;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;

class Add implements ActionInterface
{
    protected PageFactory $pageFactory;
    private Logger $logger;

    public function __construct(
        PageFactory $rawFactory,
        Logger      $logger
    )
    {
        $this->pageFactory = $rawFactory;
        $this->logger = $logger;
    }

    public function execute()
    {
        $this->pageFactory->create();
        echo 'TEST';
        exit;
        $this->logger->info('START send SMS Subscription');
        return $this->pageFactory->create();
    }
}
