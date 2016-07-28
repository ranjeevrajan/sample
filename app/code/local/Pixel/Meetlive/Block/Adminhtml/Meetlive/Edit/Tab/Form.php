<?php

class Pixel_Meetlive_Block_Adminhtml_Meetlive_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form {

    protected function _prepareForm() {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('meetlive_form', array('legend' => Mage::helper('meetlive')->__('Item information')));

        $fieldset->addField('name', 'text', array(
            'label' => Mage::helper('meetlive')->__('Name'),
            'class' => 'required-entry',
            'required' => true,
            'readonly' => 'readonly',
            'name' => 'name'
        ));

        $fieldset->addField('email', 'text', array(
            'label' => Mage::helper('meetlive')->__('Email'),
            'class' => 'required-entry',
            'required' => true,
            'readonly' => 'readonly',
            'name' => 'email'
        ));

		$fieldset->addField('day', 'date', array(
            'label' => Mage::helper('meetlive')->__('Date selection'),
            'name' => 'day',
			'image'	=> $this->getSkinUrl('images/grid-cal.gif'),
            'format'	=> Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT)
        ));

        $fieldset->addField('status', 'select', array(
            'label' => Mage::helper('meetlive')->__('Status'),
            'name' => 'status',
            'values' => array(
                array(
                    'value' => 1,
                    'label' => Mage::helper('meetlive')->__('Enabled'),
                ),
                array(
                    'value' => 2,
                    'label' => Mage::helper('meetlive')->__('Disabled'),
                )
            )
        ));


        if (Mage::getSingleton('adminhtml/session')->getMeetliveData()) {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getMeetliveData());
            Mage::getSingleton('adminhtml/session')->setMeetliveData(null);
        } elseif (Mage::registry('meetlive_data')) {
            $form->setValues(Mage::registry('meetlive_data')->getData());
        }
        return parent::_prepareForm();
    }

}