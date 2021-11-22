<?php

namespace Academy\ProductFeed\Block\Adminhtml\Feed\Edit;

class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    public function __construct(
        \Magento\Backend\Block\Template\Context  $context,
        \Magento\Framework\Json\EncoderInterface $jsonEncoder,
        \Magento\Backend\Model\Auth\Session      $authSession,
        \Magento\Framework\Registry              $coreRegistry,
        array                                    $data = []
    )
    {
        $this->_coreRegistry = $coreRegistry;
        parent::__construct($context, $jsonEncoder, $authSession, $data);
    }

    protected function _construct()
    {
        parent::_construct();
        $this->setId('feed_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Product Feed Information'));
    }

    protected function _prepareLayout()
    {
        $this->addTab(
            'general',
            [
                'label' => __('General'),
                'content' => $this->getLayout()->createBlock(
                    'Academy\ProductFeed\Block\Adminhtml\Feed\Edit\Tab\General'
                )->toHtml(),
                'active' => true
            ]
        );

        $this->addTab(
            'product_information',
            [
                'label' => __('Product Information'),
                'content' => $this->getLayout()->createBlock(
                    'Academy\ProductFeed\Block\Adminhtml\Feed\Edit\Tab\ProductInformation'
                )->toHtml(),
                'active' => true
            ]
        );

        $this->addTab(
            'template',
            [
                'label' => __('Template'),
                'content' => $this->getLayout()->createBlock(
                    'Academy\ProductFeed\Block\Adminhtml\Feed\Edit\Tab\Template'
                )->toHtml()
            ]
        );

        $this->addTab(
            'ftp',
            [
                'label' => __('FTP'),
                'content' => $this->getLayout()->createBlock(
                    'Academy\ProductFeed\Block\Adminhtml\Feed\Edit\Tab\Ftp'
                )->toHtml()
            ]
        );

        $this->addTab(
            'filter',
            [
                'label' => __('Filter'),
                'content' => $this->getLayout()->createBlock(
                    'Academy\ProductFeed\Block\Adminhtml\Feed\Edit\Tab\Filter'
                )->toHtml()
            ]
        );

        $this->addTab(
            'history',
            [
                'label' => __('History'),
                'content' => $this->getLayout()->createBlock(
                    'Academy\ProductFeed\Block\Adminhtml\Feed\Edit\Tab\History'
                )->toHtml()
            ]
        );

        return parent::_prepareLayout();
    }
}
