<?php
/**
 * @version   1.0 14.08.2012
 * @author    TonyEcommerce http://www.TonyEcommerce.com <support@TonyEcommerce.com>
 * @copyright Copyright (c) 2012 TonyEcommerce
 */

class Etheme_dresscodeslider_Adminhtml_dresscodesliderController extends Mage_Adminhtml_Controller_Action
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('etheme/dresscode/dresscodeslider/items')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Slideshowadv Manager'), Mage::helper('adminhtml')->__('Slideshowadv Manager'));
		
		return $this;
	}   
 
	public function indexAction() {
		$this->_initAction()
			->_addContent($this->getLayout()->createBlock('dresscodeslider/adminhtml_dresscodeslider'))
			->renderLayout();
	}

	public function editAction() {
		$Id     = $this->getRequest()->getParam('id');
        $Model  = Mage::getModel('dresscodeslider/dresscodeslider')->load($Id);

        if ($Model->getId() || $Id == 0) {

            Mage::register('dresscodeslider_data', $Model);
            $this->loadLayout();
            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Slideshowadv Manager'), Mage::helper('adminhtml')->__('Slideshowadv Manager'));
            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
            $this->_addContent($this->getLayout()->createBlock('dresscodeslider/adminhtml_dresscodeslider_edit'))
                 ->_addLeft($this->getLayout()->createBlock('dresscodeslider/adminhtml_dresscodeslider_edit_tabs'));
            $this->renderLayout();
        } else {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('dresscodeslider')->__('Slide does not exist'));
            $this->_redirect('*/*/');
        }
	}
 
	public function newAction() {
		$this->_forward('edit');
	}
 
	public function saveAction() {
            $formData=$this->getRequest()->getPost();            
            if ($formData) {
                try {                    


                    Mage::helper('dresscodeslider')->fileLoad('image',$formData,'etheme/dresscode/dresscodeslider');
                    Mage::helper('dresscodeslider')->fileLoad('image1',$formData,'etheme/dresscode/dresscodeslider');


                    $dresscodesliderModel = Mage::getModel('dresscodeslider/dresscodeslider');

                    $dresscodesliderModel->setData($formData) ->setId($this->getRequest()->getParam('id'))->save();
                   
                    Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Slide was successfully saved'));
                    Mage::getSingleton('adminhtml/session')->setdresscodesliderData(false);

                    if ($this->getRequest()->getParam('back'))
                    {
                        $this->_redirect('*/*/edit', array('id' => $dresscodesliderModel->getId()));
                        return;
                    }

                    $this->_redirect('*/*/');
                    return;
                } catch (Exception $e) {
                    Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                    Mage::getSingleton('adminhtml/session')->setdresscodesliderData($this->getRequest()->getPost());
                    $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                    return;
                }
            }
            $this->_redirect('*/*/');
           
	  			
	  			

	}
 
	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0 ) {
            try {
                $dresscodesliderModel = Mage::getModel('dresscodeslider/dresscodeslider');
               
                $dresscodesliderModel->setId($this->getRequest()->getParam('id'))
                    ->delete();
                   
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Slide was successfully deleted'));
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            }
        }
        $this->_redirect('*/*/');
	}

    public function gridAction()
    {
        $this->loadLayout();
        $this->getResponse()->setBody(
               $this->getLayout()->createBlock('dresscodeslider/adminhtml_dresscodeslider_grid')->toHtml()
        );
    }
}