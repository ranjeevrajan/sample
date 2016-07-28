<?php
/**
 * @author Abdullah
 */

class Offi_CustomerAttribute_Model_Attributemetada extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('customerattribute/attributemetada');
    }
    
    public function setDescriptValues($data) {
        if(is_array($data)) {
            if($this->validateDescription($data)) {
                $this->setData('description', $data[0]);
            }
            
            $this->fetchStoreDescriptions($data);
        }
    }
    
    public function validateDescription($data)
    {
        if(array_key_exists(0, $data)) {
            return true;
        }
        return false;
    }
    
    public function fetchStoreDescriptions($data) {
        $storeDescriptions = array();
        foreach ($data as $key=>$val) {
            if($key!=0) {
                $storeDescriptions[$key] = $val;
            }
        }
        $this->setStoreDescriptions($storeDescriptions);
    }
    
    public function getStoreDescriptionLabel() {
        $descriptions = Mage::getModel('customerattribute/descriptions');
        $descriptions->setData('attribute_metadata', $this);
        $store_description_labels = $descriptions->getDescriptionLabelValues();
        //print_r($store_description_labels);
        if($store_description_labels[Mage::app()->getStore()->getId()]!='') {
            return $store_description_labels[Mage::app()->getStore()->getId()];
        } else {
            return $this->getData('description');
        }
    }
}