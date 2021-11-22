<?php

namespace Academy\ProductFeed\Block\Adminhtml\Products;

class Grid
{
    static public function getCategories()
    {
        $data_array = array();
        foreach (\Academy\ProductFeed\Block\Adminhtml\ProductsGrid\Grid::getCategoryTree() as $k => $v) {
            $data_array[] = array('value' => $k, 'label' => $v);
        }
        return ($data_array);

    }
}
