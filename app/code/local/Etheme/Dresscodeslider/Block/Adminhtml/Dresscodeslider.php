<?php
/**
 * @version   1.0 14.08.2012
 * @author    TonyEcommerce http://www.TonyEcommerce.com <support@TonyEcommerce.com>
 * @copyright Copyright (c) 2012 TonyEcommerce
 */

class Etheme_dresscodeslider_Block_Adminhtml_dresscodeslider extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	public function __construct()
	{
		$this->_controller = 'adminhtml_dresscodeslider';
		$this->_blockGroup = 'dresscodeslider';
		$this->_headerText = Mage::helper('dresscodeslider')->__('Item Manager');
		$this->_addButtonLabel = Mage::helper('dresscodeslider')->__('Add Item');
		parent::__construct();
	}
}