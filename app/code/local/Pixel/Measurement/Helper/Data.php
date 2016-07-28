<?php

class Pixel_Measurement_Helper_Data extends Mage_Core_Helper_Abstract {

    public function isPopupshow() {
        $quote_items = Mage::getSingleton('checkout/session')->getQuote()->getAllItems();
        $category_collection = array();
        foreach ($quote_items as $item) {
            foreach ($item->getProduct()->getCategoryIds() as $id) {
                $category_collection[] = $id;
            }
        }

        $category_collection = array_unique($category_collection);
        if (count($category_collection) > 0) {
            foreach ($category_collection as $category_id) {
                $category_model = Mage::getModel('catalog/category')->load($category_id);
                if ($category_model->getData('is_popup_open')) {
                    return true;
                }
            }
        }

        return false;
    }

    public function getTotalMeasurement() {
        $metadata_collection = Mage::getModel('customerattribute/attributemetada')->getCollection()
                                ->addFieldToSelect('attribute_id');
        $attr_ids = array();
        $readonce = Mage::getSingleton('core/resource')->getConnection('core_read');
        $rows = $readonce->fetchAll($metadata_collection->getSelect());
        foreach ($rows as $row) {
            $attr_ids[] = $row['attribute_id'];
        }

        if(count($attr_ids)>0) {
            $condition = $this->addAttrIdFilter($attr_ids);
            if($condition) {
                $collection = Mage::getResourceModel('eav/entity_attribute_collection')
                    ->setEntityTypeFilter(Mage::getModel('eav/entity')->setType('customer')->getTypeId())
                    ->addFieldToFilter('main_table.attribute_id', $condition);
                return $collection;
            }
        }
        
        return null;
    }

    /**
     * Add collection filters by identifiers
     *
     * @param mixed $attributeId
     * @param boolean $exclude
     * @return mixed
     */
    public function addAttrIdFilter($attributeId, $exclude = false) {
        if (empty($attributeId)) {
            return false;
        }

        if (is_array($attributeId)) {
            if (!empty($attributeId)) {
                if ($exclude) {
                    $condition = array('nin' => $attributeId);
                } else {
                    $condition = array('in' => $attributeId);
                }
            } else {
                $condition = '';
            }
        } else {
            if ($exclude) {
                $condition = array('neq' => $attributeId);
            } else {
                $condition = $attributeId;
            }
        }

        return $condition;
    }
    
    public function getQuoteMeasurement() {
        $quote = Mage::getSingleton('checkout/session')->getQuote();
        $measurements = $this->getTotalMeasurement();
        $measurement_data = array();
        foreach ($measurements as $measurement) {
            $checkout_data = unserialize(Mage::getSingleton('checkout/session')->getData('body_measurement'));
            $quote_data = unserialize($quote->getData('body_measurement'));
            if (array_key_exists($measurement->getData('attribute_code'), $checkout_data)) {
                $measurement_data[$measurement->getData('attribute_code')] = $checkout_data[$measurement->getData('attribute_code')];
            } elseif (array_key_exists($measurement->getData('attribute_code'), $quote_data)) {
                $measurement_data[$measurement->getData('attribute_code')] = $quote_data[$measurement->getData('attribute_code')];
            } elseif (Mage::getSingleton('customer/session')->isLoggedin()) {
                $customer_data = Mage::getSingleton('customer/session')->getCustomer()->getData();
                $measurement_data[$measurement->getData('attribute_code')] = $customer_data[$measurement->getData('attribute_code')];
            }
        }
        return serialize($measurement_data);
    }

}
