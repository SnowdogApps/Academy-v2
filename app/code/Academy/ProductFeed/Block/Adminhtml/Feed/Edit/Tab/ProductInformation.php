<?php

namespace Academy\ProductFeed\Block\Adminhtml\Feed\Edit\Tab;

class ProductInformation extends \Magento\Backend\Block\Widget\Form\Generic
{
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry             $registry,
        \Magento\Framework\Data\FormFactory     $formFactory,
        array                                   $data = []
    )
    {
        parent::__construct($context, $registry, $formFactory, $data);
    }

    protected function _prepareForm()
    {
        $model = $this->_coreRegistry->registry('feed_data');

        $form = $this->_formFactory->create();

        $form->setHtmlIdPrefix('product_feed_');

        $fieldset = $form->addFieldset(
            'base_fieldset',
            ['legend' => __('Product Information'), 'class' => 'fieldset-wide']
        );

        $fieldset->addField('product_feed_id', 'hidden', ['name' => 'product_feed_id']);

        $form->setValues($model->getData());
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
