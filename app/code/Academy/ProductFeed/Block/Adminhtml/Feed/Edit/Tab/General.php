<?php

namespace Academy\ProductFeed\Block\Adminhtml\Feed\Edit\Tab;

class General extends \Magento\Backend\Block\Widget\Form\Generic
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
            ['legend' => __('General'), 'class' => 'fieldset-wide']
        );

        $fieldset->addField('product_feed_id', 'hidden', ['name' => 'product_feed_id']);

        $fieldset->addField(
            'name',
            'text',
            [
                'name' => 'name',
                'label' => __('Name'),
                'id' => 'name',
                'title' => __('Name'),
                'class' => 'required-entry',
                'required' => true,
            ]
        );

        $fieldset->addField(
            'status',
            'select',
            [
                'name' => 'status',
                'label' => __('Status'),
                'options' => [0 => __('Disabled'), 1 => __('Enabled')],
                'id' => 'status',
                'title' => __('Status'),
                'class' => 'required-entry',
                'required' => true,
            ]
        );

        $fieldset->addField(
            'filename',
            'text',
            [
                'name' => 'filename',
                'label' => __('File name'),
                'id' => 'filename',
                'title' => __('File name'),
                'class' => 'required-entry',
                'required' => true,
            ]
        );

        $form->setValues($model->getData());
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
