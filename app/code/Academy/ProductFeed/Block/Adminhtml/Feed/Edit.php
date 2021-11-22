<?php

namespace Academy\ProductFeed\Block\Adminhtml\Feed;

class Edit extends \Magento\Backend\Block\Widget\Form\Container
{

    protected function _construct()
    {
        $this->_objectId = 'id';
        $this->_blockGroup = 'Academy_ProductFeed';
        $this->_controller = 'adminhtml_feed';
        parent::_construct();
        $this->buttonList->remove('delete');
    }
}
