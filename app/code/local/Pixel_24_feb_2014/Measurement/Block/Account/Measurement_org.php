<?php
class Pixel_Measurement_Block_Account_Measurement extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
	public function getAttributeMetaInformation($id)
	{
		$collection = Mage::getModel('customerattribute/attributemetada')->getCollection()
					->addFieldToFilter('attribute_id',array('eq'=>$id));
		$collection->getSelect()->distinct();
		foreach($collection as $model){
			return $model;
		}
		$model = new Varien_Object();
		$model->setData('');
		return $model;
	}
	
    public function getMeasurement()     
    { 
        if (!$this->hasData('measurement')) {
			$collection = Mage::getResourceModel('eav/entity_attribute_collection')
				->setEntityTypeFilter( Mage::getModel('eav/entity')->setType('customer')->getTypeId() )
				->addFilter("is_user_defined", 1) //Pixel code
				->addFilter("is_visible", 1)
				->addFilter("is_unique", 0);
            $this->setData('measurement', $collection);
        }
        return $this->getData('measurement');
        
    }
	
	public function getInitialMeasurement()     
    {         
		$collection = Mage::getResourceModel('eav/entity_attribute_collection')
			->setEntityTypeFilter( Mage::getModel('eav/entity')->setType('customer')->getTypeId() )
			->addFilter("is_user_defined", 1) //Pixel code
			->addFilter("is_visible", 1)
			->addFilter("is_unique", 1);
		return $collection;
    }
	
	public function getTotalMeasurement()     
    { 
		$collection = Mage::getResourceModel('eav/entity_attribute_collection')
			->setEntityTypeFilter( Mage::getModel('eav/entity')->setType('customer')->getTypeId() )
			->addFilter("is_user_defined", 1) //Pixel code
			->addFilter("is_visible", 1);
		return $collection;
    }
	
	public function getQuoteMeasurement()
	{
		$measurements = $this->getTotalMeasurement();
		$measurement_data = array();
		$customer_data = Mage::getSingleton('customer/session')->getCustomer()->getData();
		
		foreach( $measurements as $measurement ){
			$measurement_data[$measurement->getData('attribute_code')] = $customer_data[$measurement->getData('attribute_code')];
		}
	
		return $measurement_data;
	}
}