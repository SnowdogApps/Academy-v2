<?php

namespace Academy\ProductFeed\Controller\Adminhtml\Manage;

use Exception;
use Magento\Backend\Model\View\Result\RedirectFactory;
use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\Request\Http;
use Magento\Framework\Message\Manager;
use Academy\ProductFeed\Model\ProductFeedFactory;
use Academy\ProductFeed\Model\ResourceModel\ProductFeed;

class Save implements ActionInterface
{
    private $request;
    private $feedResource;
    private $feedFactory;
    private $redirectFactory;
    private $messageManager;

    public function __construct(
        Http               $request,
        ProductFeed        $feedResource,
        ProductFeedFactory $feedFactory,
        RedirectFactory    $redirectFactory,
        Manager            $messageManager
    )
    {
        $this->request = $request;
        $this->feedResource = $feedResource;
        $this->feedFactory = $feedFactory;
        $this->redirectFactory = $redirectFactory;
        $this->messageManager = $messageManager;
    }

    public function execute()
    {
        $data = $this->request->getPostValue();
        $productFeed = $this->feedFactory->create();

        $this->prepareDataToSave($productFeed, $data);

        $this->saveProductFeed($productFeed);

        return $this->redirectFactory->create()->setPath('*/*/');
    }

    /**
     * @param \Academy\ProductFeed\Model\ProductFeed $productFeed
     * @param $data
     */
    private function prepareDataToSave(\Academy\ProductFeed\Model\ProductFeed $productFeed, $data): void
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
     * @param \Academy\ProductFeed\Model\ProductFeed $productFeed
     */
    private function saveProductFeed(\Academy\ProductFeed\Model\ProductFeed $productFeed): void
    {
        try {
            $this->feedResource->save($productFeed);
            $this->messageManager->addSuccessMessage('Product Feed saved!');
        } catch (Exception $e) {
            $this->messageManager->addErrorMessage('Error while saving new Product Feed!');
        }
    }
}
