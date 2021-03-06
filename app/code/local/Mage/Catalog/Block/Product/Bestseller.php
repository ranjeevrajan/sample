<?php
class Mage_Catalog_Block_Product_Bestseller extends Mage_Catalog_Block_Product_Abstract
{
    public function __construct()
    {
        parent::__construct();

        $storeId    = Mage::app()->getStore()->getId();

        $products = Mage::getResourceModel('reports/product_collection')
            ->addOrderedQty()
            //->addAttributeToSelect('*')
            ->addAttributeToSelect(array('name', 'price', 'small_image', 'short_description', 'description')) //edit to suit tastes
            ->setStoreId($storeId)
            ->addStoreFilter($storeId)
			->addAttributeToFilter('status', 1)

            ->setOrder('ordered_qty', 'desc'); //best sellers on top
        
        Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($products);
        Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($products);

        //$products->setPageSize(6)->setCurPage(1);

        $this->setProductCollection($products);
    }
}
?>