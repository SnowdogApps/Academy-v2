<?php

namespace Academy\ProductFeed\Controller\Adminhtml\Manage;

use Magento\Framework\App\ActionInterface;
use Magento\Framework\View\Result\PageFactory;

class Add implements ActionInterface
{
    private $pageFactory;

    public function __construct(PageFactory $pageFactory)
    {
        $this->pageFactory = $pageFactory;
    }

    public function execute()
    {
        return $this->pageFactory->create();
    }
}
