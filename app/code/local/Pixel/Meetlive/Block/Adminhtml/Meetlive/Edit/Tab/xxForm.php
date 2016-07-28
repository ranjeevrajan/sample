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

		$fieldset->addField('day', 'select', array(
            'label' => Mage::helper('meetlive')->__('Dates selection'),
            'name' => 'day',
            'values' => array(
                
                array(
                    'value' => 'day1',
                    'label' => Mage::helper('meetlive')->__('Tomorrow + 1')
                ),
                array(
                    'value' => 'day2',
                    'label' => Mage::helper('meetlive')->__('Tomorrow + 2')
                ),
                array(
                    'value' => 'day3',
                    'label' => Mage::helper('meetlive')->__('Tomorrow + 3')
                ),
                array(
                    'value' => 'day4',
                    'label' => Mage::helper('meetlive')->__('Tomorrow + 4')
                ),
                array(
                    'value' => 'day5',
                    'label' => Mage::helper('meetlive')->__('Tomorrow + 5')
                )
            )
        ));
		
		
        $fieldset->addField('nearest_city', 'text', array(
            'label' => Mage::helper('meetlive')->__('Nearest City'),
            'name' => 'nearest_city'
        ));
        
        $fieldset->addField('suitable_time', 'select', array(
            'label' => Mage::helper('meetlive')->__('Suitable Time'),
            'name' => 'suitable_time',
            'values' => array(
                
                array(
                    'value' => 'after_6pm',
                    'label' => Mage::helper('meetlive')->__('After 6pm')
                ),
                array(
                    'value' => '2_30_6pm',
                    'label' => Mage::helper('meetlive')->__('2:30 pm - 6 pm')
                ),
                array(
                    'value' => '12pm_2_30pm',
                    'label' => Mage::helper('meetlive')->__('12 pm - 2:30 pm')
                ),
                array(
                    'value' => '9am_12pm',
                    'label' => Mage::helper('meetlive')->__('9 am -12 pm')
                )
            )
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