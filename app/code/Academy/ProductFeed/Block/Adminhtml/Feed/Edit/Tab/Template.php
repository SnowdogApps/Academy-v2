<?php

namespace Academy\ProductFeed\Block\Adminhtml\Feed\Edit\Tab;

class Template extends \Magento\Backend\Block\Widget\Form\Generic
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
            ['legend' => __('Template'), 'class' => 'fieldset-wide']
        );

        $fieldset->addField('product_feed_id', 'hidden', ['name' => 'product_feed_id']);

        $fieldset->addField(
            'file_type',
            'select',
            [
                'name' => 'file_type',
                'label' => __('File type'),
                'options' => ['XML' => __('XML'), 'CSV' => __('CSV'), 'TXT' => __('TXT')],
                'id' => 'file_type',
                'title' => __('File type'),
                'class' => 'required-entry',
                'required' => true,
            ]
        );

        $fieldset->addField(
            'template_content',
            'textarea',
            [
                'name' => 'template_content',
                'label' => __('Template content'),
                'id' => 'template_content',
                'title' => __('Template content'),
                'class' => 'required-entry',
                'required' => true,
            ]
        );
        
        $form->setValues($model->getData());
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
