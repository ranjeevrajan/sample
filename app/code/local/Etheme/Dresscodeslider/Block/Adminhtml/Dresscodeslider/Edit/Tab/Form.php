<?php
/**
 * @version   1.0 14.08.2012
 * @author    TonyEcommerce http://www.TonyEcommerce.com <support@TonyEcommerce.com>
 * @copyright Copyright (c) 2012 TonyEcommerce
 */

class Etheme_Dresscodeslider_Block_Adminhtml_Dresscodeslider_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('dresscodeslider_form', array('legend'=>Mage::helper('dresscodeslider')->__('Item information')));

	  $fieldset->addField('link', 'text', array(
          'label'     => Mage::helper('dresscodeslider')->__('Link Left'),
          'required'  => false,
          'name'      => 'link',
          'index'      => 'link',
      ));

      $fieldset->addField('link_1', 'text', array(
          'label'     => Mage::helper('dresscodeslider')->__('Link Right'),
          'required'  => false,
          'name'      => 'link_1',
          'index'      => 'link_1',
      ));


	  $data = array();
	  if ( Mage::getSingleton('adminhtml/session')->getdresscodesliderData() )
      {
			$data = Mage::getSingleton('adminhtml/session')->getdresscodesliderData();
	  } elseif ( Mage::registry('dresscodeslider_data') ) {
			$data = Mage::registry('dresscodeslider_data')->getData();
	  }


	  $imgfront='';
      if (!empty($data['image']) )$imgfront = '<br/><a href="' . Mage::getBaseUrl('media').$data['image'] . '" target="_blank" >'."<img src=" . Mage::getBaseUrl('media').$data['image'] . " width='200px' alt='' /></a>";

      $fieldset->addField('image', 'file', array(
          'label'     => Mage::helper('dresscodeslider')->__('Slide Image'),
          'name'      => 'image',
	      'note' => $imgfront,
	  ));


      $imgfront1='';
      if (!empty($data['image1']) )$imgfront1 = '<br/><a href="' . Mage::getBaseUrl('media').$data['image1'] . '" target="_blank" >'."<img src=" . Mage::getBaseUrl('media').$data['image1'] . " width='200px' alt='' /></a>";

      $fieldset->addField('image1', 'file', array(
          'label'     => Mage::helper('dresscodeslider')->__('Slide Image1'),
          'name'      => 'image1',
	      'note' => $imgfront1,
	  ));





      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('dresscodeslider')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('dresscodeslider')->__('Active'),
              ),
              array(
                  'value'     => 2,
                  'label'     => Mage::helper('dresscodeslider')->__('Inactive'),
              ),
          ),
      ));

      if ( Mage::getSingleton('adminhtml/session')->getdresscodesliderData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getdresscodesliderData());
          Mage::getSingleton('adminhtml/session')->setdresscodesliderData(null);
      } elseif ( Mage::registry('dresscodeslider_data') ) {
          $form->setValues(Mage::registry('dresscodeslider_data')->getData());
      }
      return parent::_prepareForm();
  }
}