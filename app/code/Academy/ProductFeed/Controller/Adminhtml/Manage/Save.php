<?php

namespace Academy\ProductFeed\Controller\Adminhtml\Manage;

use Magento\Backend\Model\View\Result\RedirectFactory;
use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\Request\Http;
use Academy\ProductFeed\Model\ProductFeedFactory;
use Academy\ProductFeed\Model\ProductFeedManager;

class Save implements ActionInterface
{
    private $request;
    private $feedFactory;
    private $redirectFactory;
    private $productFeedManager;

    public function __construct(
        Http               $request,
        ProductFeedFactory $feedFactory,
        RedirectFactory    $redirectFactory,
        ProductFeedManager $productFeedManager
    )
    {
        $this->request = $request;
        $this->feedFactory = $feedFactory;
        $this->redirectFactory = $redirectFactory;
        $this->productFeedManager = $productFeedManager;
    }

    public function execute()
    {
        $data = $this->request->getPostValue();

        $productFeed = $this->feedFactory->create();

        $this->productFeedManager->prepareDataToSave($productFeed, $data);

        $this->productFeedManager->saveProductFeed($productFeed);

        return $this->redirectFactory->create()->setPath('*/*/');
    }
}
