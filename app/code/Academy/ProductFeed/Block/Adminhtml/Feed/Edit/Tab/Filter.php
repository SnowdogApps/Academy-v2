<?php

namespace Academy\ProductFeed\Block\Adminhtml\Feed\Edit\Tab;

class Filter extends \Magento\Backend\Block\Widget\Form\Generic
{
    private $categoryManagement;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry             $registry,
        \Magento\Framework\Data\FormFactory     $formFactory,
        \Magento\Catalog\Block\Adminhtml\Category\Tree $categoryManagement,
        array                                   $data = []
    )
    {
        parent::__construct($context, $registry, $formFactory, $data);
        $this->categoryManagement = $categoryManagement;
    }

    protected function _prepareForm()
    {
        $model = $this->_coreRegistry->registry('feed_data');

        $form = $this->_formFactory->create();

        $form->setHtmlIdPrefix('product_feed_');

        $fieldset = $form->addFieldset(
            'base_fieldset',
            ['legend' => __('Filter'), 'class' => 'fieldset-wide']
        );

        $fieldset->addField('product_feed_id', 'hidden', ['name' => 'product_feed_id']);

        $fieldset->addField(
            'categories',
            'multiselect',
            [
                'label' => __('Categories'),
                'title' => __('Categories'),
                'name' => 'categories',
                'values' => \Academy\ProductFeed\Block\Adminhtml\Products\Grid::getCategories(),
                'note' => __('Could be multiple'),
                'disabled' => false
            ]
        );

        $form->setValues($model->getData());
        $this->setForm($form);

        return parent::_prepareForm();
    }
}

