<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Mage
 * @package     Mage_Catalog
 * @copyright   Copyright (c) 2012 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */


/**
 * Product list
 *
 * @category   Mage
 * @package    Mage_Catalog
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Mage_Catalog_Block_Product_Specials extends Mage_Catalog_Block_Product_Abstract
{
	
	
    public function __construct()
    {
        parent::__construct();

        $storeId    = Mage::app()->getStore()->getId();
		
		$dateToday = date('m/d/y');
		 $tomorrow = mktime(0, 0, 0, date('m'), date('d')+1, date('y'));
		 $dateTomorrow = date('m/d/y', $tomorrow);

        $products = Mage::getResourceModel('catalog/product_collection')
			->addAttributeToFilter('special_from_date', array('date' => true, 'to' => $dateToday))
		    ->addAttributeToFilter('special_to_date', array('or'=> array(
			0 => array('date' => true, 'from' => $dateTomorrow),
			1 => array('is' => new Zend_Db_Expr('null')))
		 ), 'left')
		 
		 	->addAttributeToFilter('status', 1)
		 
			->addAttributeToSelect(array('name', 'price', 'small_image', 'short_description', 'description', 'special_price')) //edit to suit tastes
            ->setStoreId($storeId)
            ->addStoreFilter($storeId);

        
        Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($products);
        Mage::getSingleton('catalog/product_visibility')->getVisibleInCatalogIds($products);

        //$products->setPageSize(6)->setCurPage(1);

        $this->setProductCollection($products);
    }
	
	
	
}
