<?php
class Pixel_Meetlive_Block_Adminhtml_Meetlive extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_meetlive';
    $this->_blockGroup = 'meetlive';
    $this->_headerText = Mage::helper('meetlive')->__('Item Manager');
    $this->_addButtonLabel = Mage::helper('meetlive')->__('Add Item');
    parent::__construct();
    $this->_removeButton('add');
  }
}