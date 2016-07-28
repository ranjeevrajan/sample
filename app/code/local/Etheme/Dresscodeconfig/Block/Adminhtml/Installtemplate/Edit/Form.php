<?php
/**
 * @version   1.0 14.08.2012
 * @author    TonyEcommerce http://www.TonyEcommerce.com <support@TonyEcommerce.com>
 * @copyright Copyright (c) 2012 TonyEcommerce
 */

class Etheme_Dresscodeconfig_Block_Adminhtml_Installtemplate_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form_builder = new Varien_Data_Form();
        $fieldset = $form_builder->addFieldset('action_fieldset', array('legend'=>Mage::helper('dresscodeconfig')->__('Choose your action and click Submit')));


        $fieldset->addField('store_id', 'select', array(
            'name'      => 'store',
            'title'     => Mage::helper('cms')->__('Store View'),
            'label'     => Mage::helper('cms')->__('Store View'),
            'values'    => Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(false, true),
        ));
       
        $fieldset->addField('action', 'select', array(
            'name'      => 'action',
            'title'     => Mage::helper('cms')->__('Store View'),
            'label'     => Mage::helper('cms')->__('Action'),
            'values'    => array(array('value'=>'install','label'=>'Install Dresscode'),
                                 array('value'=>'uninstall',  'label'=>'Uninstall Dresscode (returns previous template)'),
                                 array('value'=>'reset',  'label'=>'Restore template settings')
                                ),

        ));

        $form_builder->setMethod('post');
        $form_builder->setAction($this->getUrl('*/*/dispatch'));
        $form_builder->setUseContainer(true);
        $form_builder->setId('edit_form');
        $this->setForm($form_builder);
        
        return parent::_prepareForm();
    }
}
