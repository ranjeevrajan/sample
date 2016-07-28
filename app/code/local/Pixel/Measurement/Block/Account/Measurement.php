<?php

class Pixel_Measurement_Block_Account_Measurement extends Mage_Core_Block_Template {

    public function _prepareLayout() {
        return parent::_prepareLayout();
    }

    public function getAttributeMetaInformation($id) {
        $collection = Mage::getModel('customerattribute/attributemetada')->getCollection()
                ->addFieldToFilter('attribute_id', array('eq' => $id));
        $collection->getSelect()->distinct();
        foreach ($collection as $model) {
            return $model;
        }
        $model = new Varien_Object();
        $model->setData('');
        return $model;
    }

    public function getMeasurement() {
        if (!$this->hasData('measurement')) {
            $collection = $this->getTotalMeasurement();
            if($collection) {
                $collection->getSelect()->join(array('attributemetada_table' => Mage::getModel('core/resource')->getTableName('customerattribute/attributemetada')),
                        'attributemetada_table.attribute_id = main_table.attribute_id',
                        array(
                            'attributemetada_table.is_body_shape',
                            'attributemetada_table.sort_order'
                        )
                    )->where('attributemetada_table.is_body_shape = ?', 0);
                $collection->setorder('attributemetada_table.sort_order', 'ASC');

                $this->setData('measurement', $collection);
            }
        }
        return $this->getData('measurement');
    }

    public function getBodyShapeMeasurement() {
        $collection = $this->getTotalMeasurement();
        if($collection) {
            $collection->getSelect()->join(array('attributemetada_table' => Mage::getModel('core/resource')->getTableName('customerattribute/attributemetada')),
                    'attributemetada_table.attribute_id = main_table.attribute_id',
                    array(
                        'attributemetada_table.is_body_shape',
                        'attributemetada_table.sort_order'
                    )
                )->where('attributemetada_table.is_body_shape = ?', 1);
            $collection->setorder('attributemetada_table.sort_order', 'ASC');
        }
        return $collection;
    }

    /**
     * Add collection filters by identifiers
     *
     * @param mixed $attributeId
     * @param boolean $exclude
     * @return mixed
     */
    public function addAttrIdFilter($attributeId, $exclude = false)
    {
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

    public function getQuoteMeasurement() {
        $measurements = $this->getTotalMeasurement();
        $measurement_data = array();
        $customer_data = Mage::getSingleton('customer/session')->getCustomer()->getData();

        foreach ($measurements as $measurement) {
            $measurement_data[$measurement->getData('attribute_code')] = $customer_data[$measurement->getData('attribute_code')];
        }

        return $measurement_data;
    }

}
