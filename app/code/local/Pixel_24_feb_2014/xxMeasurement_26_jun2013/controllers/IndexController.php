<?php
/**
 * Magento Customization
 * @Author : Abdullah
 *
 */
?>


<?php
class Pixel_Measurement_IndexController extends Mage_Core_Controller_Front_Action
{

	public function measurementAction()
    {
		$this->loadLayout();     
		$this->renderLayout();
	}

	public function saveintoquoteAction()
	{
		$params = $this->getRequest()->getParams();
		$response = array();
		$body_measurement = array();
		try {
			$checkout_session = Mage::getSingleton('checkout/session');
			$body_measurement = $checkout_session->getData('body_measurement');
			//$body_measurement = '';
			if( $body_measurement ){
				$body_measurement = unserialize($body_measurement);
			}
			
			//print_r($params);
			
			foreach( $params as $key=>$param )
			{
				$body_measurement[$key] = $param;
			}
			$body_measurement = serialize($body_measurement);
			if( $checkout_session->setBodyMeasurement($body_measurement) ){
				$response['status'] = 'SUCCESS';
				$response['message'] = 'Saved!!';
			}
			else{
				$response['status'] = 'ERROR';
				$response['message'] = 'This measurement can not be saved.';
			}
			
			//print_r($response);
			//print_r($checkout_session->getData('body_measurement'));die;
			
		}catch(Mage_Core_Exception $e) {
			$msg = "";
			if ($this->_getSession()->getUseNotice(true)) {
				$msg = $e->getMessage();
			} else {
				$messages = array_unique(explode("\n", $e->getMessage()));
				foreach ($messages as $message) {
					$msg .= $message.'<br/>';
				}
			}

			$response['status'] = 'ERROR';
			$response['message'] = $msg;
		}catch(Exception $e) {
			$response['status'] = 'ERROR';
			$response['message'] = $this->__('This measurement can not be saved.');
			Mage::logException($e);
		}
		$this->getResponse()->setBody(Mage::helper('core')->jsonEncode($response));
		return;
	}
	
    public function indexAction()
    {
		echo 'Testing.....';die;
    	/*
    	 * Load an object by id 
    	 * Request looking like:
    	 * http://site.com/measurement?id=15 
    	 *  or
    	 * http://site.com/measurement/id/15 	
    	 */
    	/* 
		$measurement_id = $this->getRequest()->getParam('id');

  		if($measurement_id != null && $measurement_id != '')	{
			$measurement = Mage::getModel('measurement/measurement')->load($measurement_id)->getData();
		} else {
			$measurement = null;
		}	
		*/
		
		 /*
    	 * If no param we load a the last created item
    	 */ 
    	/*
    	if($measurement == null) {
			$resource = Mage::getSingleton('core/resource');
			$read= $resource->getConnection('core_read');
			$measurementTable = $resource->getTableName('measurement');
			
			$select = $read->select()
			   ->from($measurementTable,array('measurement_id','title','content','status'))
			   ->where('status',1)
			   ->order('created_time DESC') ;
			   
			$measurement = $read->fetchRow($select);
		}
		Mage::register('measurement', $measurement);
		*/
			
		$this->loadLayout();     
		$this->renderLayout();
    }
	
	
	
}

