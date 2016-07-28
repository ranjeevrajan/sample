<?php

class Pixel_Meetlive_Model_Meetlive extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('meetlive/meetlive');
    }
    
    public function validate()
    {
        $errors = array();
        
        if (!Zend_Validate::is( trim($this->getName()) , 'NotEmpty')) {
            $errors[] = Mage::helper('meetlive')->__('The name cannot be empty.');
        }

        if (!Zend_Validate::is($this->getEmail(), 'EmailAddress')) {
            $errors[] = Mage::helper('meetlive')->__('Invalid email address "%s".', $this->getEmail());
        }

        /*if($this->getPage()=='trade_partner') {
            if (!Zend_Validate::is($this->getTelephone(), 'NotEmpty')) {
                $errors[] = Mage::helper('meetlive')->__('The Telephone No cannot be empty');
            }
        }
        
        if (!Zend_Validate::is( trim($this->getMessage()) , 'NotEmpty')) {
            $errors[] = Mage::helper('meetlive')->__('The message cannot be empty.');
        }*/
        
        return $errors;
    }
}