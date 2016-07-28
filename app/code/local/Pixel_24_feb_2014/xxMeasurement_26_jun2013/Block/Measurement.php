<?php
class Pixel_Measurement_Block_Measurement extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
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
		$quote = Mage::getSingleton('checkout/session')->getQuote();
		$measurements = $this->getTotalMeasurement();
		$measurement_data = array();
		foreach( $measurements as $measurement ){
			$checkout_data = unserialize(Mage::getSingleton('checkout/session')->getData('body_measurement'));
			$quote_data = unserialize($quote->getData('body_measurement'));
			if( array_key_exists($measurement->getData('attribute_code'),$checkout_data) )
			{
				$measurement_data[$measurement->getData('attribute_code')] = $checkout_data[$measurement->getData('attribute_code')];
			}
			elseif( array_key_exists($measurement->getData('attribute_code'),$quote_data) )
			{
				$measurement_data[$measurement->getData('attribute_code')] = $quote_data[$measurement->getData('attribute_code')];
			}
			elseif( Mage::getSingleton('customer/session')->isLoggedin() )
			{
				$customer_data = Mage::getSingleton('customer/session')->getCustomer()->getData();
				$measurement_data[$measurement->getData('attribute_code')] = $customer_data[$measurement->getData('attribute_code')];
			}
		}
		
		/*if(($quote->getData('body_measurement'))){
			echo '=='.$quote->getData('body_measurement');
			return unserialize($quote->getData('body_measurement'));
		}
		elseif( Mage::getSingleton('customer/session')->isLoggedin() )
		{
			$customer = Mage::getSingleton('customer/session')->getCustomer();
			return $customer->getData();
		}*/
		return $measurement_data;
	}
}