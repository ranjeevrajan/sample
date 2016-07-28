<?php
/**
 * @author Abdullah
 */

class Offi_CustomerAttribute_Model_Descriptions extends Mage_Core_Model_Abstract
{
    protected $_storeDescriptions = array();
    
    public function _construct()
    {
        parent::_construct();
        $this->_init('customerattribute/descriptions');
    }
    
    public function saveRow() {
        $collection = $this->getCollection()
                        ->addFieldToFilter('attribute_id', array('eq' => $this->getAttributeId()));
        if ( count($collection) >0 ) {
            foreach ($collection as $model) {
                $model->setValue($this->getStoreDescription($model->getStoreId()));
                try {
                    $model->save();
                    unset($this->_storeDescriptions[$model->getStoreId()]);
                } catch (Exception $ex) {
                    Mage::logException($ex);
                }
            }
        }
        
        foreach ($this->_storeDescriptions as $key=>$val) {
            $description = Mage::getModel('customerattribute/descriptions');
            $description->setData('attribute_id', $this->getAttributeId())
                        ->setData('store_id', $key)
                        ->setData('value', $val);
            try {
                $description->save();
            } catch (Exception $ex) {
                Mage::logException($ex);
            }
        }
    }
    
    public function getStoreDescription($store_id) {
        if(isset($this->_storeDescriptions[$store_id])) {
            return $this->_storeDescriptions[$store_id];
        }
        return '';
    }
    
    public function setStoreDescriptions($store_descriptions) {
        $this->_storeDescriptions = $store_descriptions;
    }
    
    public function getAttributeMetaDataModel()
    {
        return $this->getData('attribute_metadata');
    }
    
    public function getStores()
    {
        $stores = $this->getData('stores');
        if (is_null($stores)) {
            $stores = Mage::getModel('core/store')
                ->getResourceCollection()
                ->setLoadDefault(true)
                ->load();
            $this->setData('stores', $stores);
        }
        return $stores;
    }
    
    public function getDescriptionLabelValues()
    {
        $values = array();
        $storeLabels = $this->getStoreDescriptions();
        foreach ($this->getStores() as $store) {
            if(isset($storeLabels[$store->getId()])) {
                $values[$store->getId()] = $storeLabels[$store->getId()];
            } else {
                $values[$store->getId()] = '';
            }
        }
        return $values;
    }
    
    public function getStoreDescriptions() {
        $store_labels = array();
        if($this->getAttributeMetaDataModel()) {
            $store_labels[0] = $this->getAttributeMetaDataModel()->getData('description');
        }
         
        $collection = Mage::getModel('customerattribute/descriptions')->getCollection()
                        ->addFieldToFilter('attribute_id', array('eq' => $this->getAttributeMetaDataModel()->getData('attribute_id')));
        foreach ($collection as $decription) {
            $store_labels[$decription->getData('store_id')] = $decription->getData('value');
        }
        return $store_labels;
    }
}
