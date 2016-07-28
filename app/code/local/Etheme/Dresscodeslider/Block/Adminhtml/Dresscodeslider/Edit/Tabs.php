<?php
/**
 * @version   1.0 14.08.2012
 * @author    TonyEcommerce http://www.TonyEcommerce.com <support@TonyEcommerce.com>
 * @copyright Copyright (c) 2012 TonyEcommerce
 */

class Etheme_Dresscodeslider_Block_Adminhtml_Dresscodeslider_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('dresscodeslider_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('dresscodeslider')->__('Item Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('dresscodeslider')->__('Slide Information'),
          'title'     => Mage::helper('dresscodeslider')->__('Slide Information'),
          'content'   => $this->getLayout()->createBlock('dresscodeslider/adminhtml_dresscodeslider_edit_tab_form')->toHtml(),
      ));
      return parent::_beforeToHtml();
  }
}