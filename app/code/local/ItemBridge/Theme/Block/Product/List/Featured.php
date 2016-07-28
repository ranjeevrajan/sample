<?php

/**
 * Featured products block
 *
 * @category    ItemBridge
 * @package     ItemBridge_Theme
 * @copyright   Copyright (c) 2012 InfoStyle (http://infostyle.com.ua)
 * @license     http://themeforest.net/licenses/regular_extended ThemeForest Regular & Extended License
 */

class ItemBridge_Theme_Block_Product_List_Featured extends Mage_Catalog_Block_Product_List
{
   /*
    * Block variables: category_id, products_count, random_products
    */
    protected function _getProductCollection()
    {
        if (is_null($this->_productCollection)) {
            $collection = ($category_id = $this->getCategoryId())
                ? Mage::getModel('catalog/category')->load($category_id)->getProductCollection()
                : Mage::getResourceModel('catalog/product_collection');

            Mage::getModel('catalog/layer')->prepareProductCollection($collection);

            if ( ! is_null($this->getRandomProducts()))
                $collection->getSelect()->order('RAND()');

            $collection->addStoreFilter();

            if (($count = $this->getProductsCount()) > 0)
                $collection->setPage(1, $count);

            $collection->load();

            $this->_productCollection = $collection;
        }

        return $this->_productCollection;
    }
}
