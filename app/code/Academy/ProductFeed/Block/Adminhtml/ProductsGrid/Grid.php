<?php

namespace Academy\ProductFeed\Block\Adminhtml\ProductsGrid;

class Grid
{

    static public function getCategoryTree($categories = "", $data_array = array())
    {
        if (empty($categories)) {
            $_objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $categoryFactory = $_objectManager->create('Magento\Catalog\Model\ResourceModel\Category\CollectionFactory');
            $categories = $categoryFactory->create()
                ->addAttributeToSelect('*')//or you can just add some attributes
                ->addAttributeToFilter('level', 2)//2 is actually the first level
                ->addAttributeToFilter('is_active', 1)//if you want only active categories
                ->addAttributeToSort('position', 'ASC');
        }

        foreach ($categories as $k => $category) {
            $level = $category->getLevel();
            $data_array[$category->getId()] = str_repeat("*", $level) . " " . $category->getName();
            $childCategories = $category->getChildrenCategories();
            if (count($childCategories) > 0) {
                $data_array = \Academy\ProductFeed\Block\Adminhtml\ProductsGrid\Grid::getCategoryTree($childCategories, $data_array);
            }
        }
        if (count($data_array) == 0) {
            return $data_array;
        }
        return ($data_array);
    }

}
