<?php

/**
 * Magento Customization
 * @Author : Abdullah
 *
 */
class Pixel_Measurement_IndexController extends Mage_Core_Controller_Front_Action {

    protected function _getSession() {
        return Mage::getSingleton('customer/session');
    }

    public function measurementAction() {
        if (Mage::helper('measurement')->isPopupshow()) {
            $this->loadLayout();
            $layout = $this->getLayout();
            $content_block = $layout->getBlock('content');
            $output = $content_block->toHtml();
            $response['html'] = $output;

            $measurement_block_obj = $this->getLayout()->createBlock('measurement/measurement');
            $save_measurement_in_quote = count($measurement_block_obj->getQuoteMeasurement());
            $response['count_save_measurement_in_quote'] = $save_measurement_in_quote;
            $response['ispopupopen'] = true;
        } else {
            $response['ispopupopen'] = false;
        }
        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($response));
        return;
    }

    public function saveintoquoteAction() {
        $params = $this->getRequest()->getParams();
        $response = array();
        $body_measurement = array();
        try {
            $checkout_session = Mage::getSingleton('checkout/session');
            $body_measurement = $checkout_session->getData('body_measurement');
            //$body_measurement = '';
            if ($body_measurement) {
                $body_measurement = unserialize($body_measurement);
            }

            //print_r($params);

            foreach ($params as $key => $param) {
                $body_measurement[$key] = $param;
            }
            $body_measurement = serialize($body_measurement);
            if ($checkout_session->setBodyMeasurement($body_measurement)) {
                $measurement_block_obj = $this->getLayout()->createBlock('measurement/measurement');
                $save_measurement_in_quote = count($measurement_block_obj->getQuoteMeasurement());
                $response['status'] = 'SUCCESS';
                $response['message'] = 'Saved!!';
                $response['count_save_measurement_in_quote'] = $save_measurement_in_quote;
            } else {
                $response['status'] = 'ERROR';
                $response['message'] = 'This measurement can not be saved.';
            }

            //print_r($response);
            //print_r($checkout_session->getData('body_measurement'));die;
        } catch (Mage_Core_Exception $e) {
            $msg = "";
            if ($this->_getSession()->getUseNotice(true)) {
                $msg = $e->getMessage();
            } else {
                $messages = array_unique(explode("\n", $e->getMessage()));
                foreach ($messages as $message) {
                    $msg .= $message . '<br/>';
                }
            }

            $response['status'] = 'ERROR';
            $response['message'] = $msg;
        } catch (Exception $e) {
            $response['status'] = 'ERROR';
            $response['message'] = $this->__('This measurement can not be saved.');
            Mage::logException($e);
        }
        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($response));
        return;
    }

    public function saveintocustomerAction() {
        $params = $this->getRequest()->getParams();
        $response = array();
        $body_measurement = array();
        try {
            $customer_session = Mage::getSingleton('customer/session');
            if ($customer_session->isLoggedIn()) {
                $customer = $customer_session->getCustomer();
                foreach ($params as $key => $param) {
                    $customer->setData($key, $param);
                }
                try {
                    $customer->save();
                    $response['status'] = 'SUCCESS';
                    $response['message'] = 'Saved!!';
                } catch (Mage_Core_Exception $e) {
                    $response['status'] = 'ERROR';
                    $response['message'] = 'This measurement can not be saved.';
                }
            }
        } catch (Mage_Core_Exception $e) {
            $msg = "";
            if ($this->_getSession()->getUseNotice(true)) {
                $msg = $e->getMessage();
            } else {
                $messages = array_unique(explode("\n", $e->getMessage()));
                foreach ($messages as $message) {
                    $msg .= $message . '<br/>';
                }
            }
            $response['status'] = 'ERROR';
            $response['message'] = $msg;
        } catch (Exception $e) {
            $response['status'] = 'ERROR';
            $response['message'] = $this->__('This measurement can not be saved.');
            Mage::logException($e);
        }
        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($response));
        return;
    }

    /* public function preDispatch()
      {
      parent::preDispatch();
      $action = $this->getRequest()->getActionName();
      $loginUrl = Mage::helper('customer')->getLoginUrl();

      if (!Mage::getSingleton('customer/session')->authenticate($this, $loginUrl)) {
      $this->setFlag('', self::FLAG_NO_DISPATCH, true);
      }
      } */

    public function bodymeasurementAction() {
        $loginUrl = Mage::helper('customer')->getLoginUrl();
        if (!Mage::getSingleton('customer/session')->authenticate($this, $loginUrl)) {
            $this->setFlag('', self::FLAG_NO_DISPATCH, true);
        }
        $this->loadLayout();
        $this->renderLayout();
    }

}

?>