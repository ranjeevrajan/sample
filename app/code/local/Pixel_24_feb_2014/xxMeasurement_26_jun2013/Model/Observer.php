<?php
/**
 * Magento Customization
 * @Author : Abdullah
 *
 */
?>


<?php
class Pixel_Measurement_Model_Observer
{
	public function hookToShippingMethodSaveEvent($observer)
	{
		$checkout_session = Mage::getSingleton('checkout/session');
		if( $body_measurement = $checkout_session->getData('body_measurement') )
		{
				$quote = Mage::getSingleton('checkout/session')->getQuote();
				try{
					$quote->setBodyMeasurement($body_measurement)->save();
				}
				catch(Mage_Core_Exception $e) {
					Mage::logException($e);
				}catch(Exception $e) {
					Mage::logException($e);
				}
		}
		return $this;
	}
	
	public function hookToOrderSaveEvent($observer)
	{
		//Saving body measurement to respective loggedin customer
		$customer_session = Mage::getSingleton('customer/session');
		if( $customer_session->isLoggedIn() )
		{
			$customer = $customer_session->getCustomer();
			if( $customer instanceof Mage_Customer_Model_Customer )
			{
				$quote = Mage::getSingleton('checkout/session')->getQuote();
				try{
					$body_measurement = unserialize($quote->getData('body_measurement'));
					if( $body_measurement ){
						foreach( $body_measurement as $key=>$_body_measurement )
						{
							$customer->setData($key,$_body_measurement);
						}
						$customer->save();
					}
				}
				catch(Mage_Core_Exception $e) {
					Mage::logException($e);
				}catch(Exception $e) {
					Mage::logException($e);
				}
			}
		}
		
		Mage::getSingleton('checkout/session')->getData('body_measurement',true);
		return $this;
	}
	
}