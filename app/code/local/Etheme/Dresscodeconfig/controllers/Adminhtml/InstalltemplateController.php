<?php
/**
 * @version   1.0 14.08.2012
 * @author    TonyEcommerce http://www.TonyEcommerce.com <support@TonyEcommerce.com>
 * @copyright Copyright (c) 2012 TonyEcommerce
 */

class Etheme_Dresscodeconfig_Adminhtml_InstalltemplateController extends Mage_Adminhtml_Controller_Action
{
	public function indexAction()
	{
        $this->loadLayout();
        $this->_addLeft($this->getLayout()->createBlock('core/text', 'leftbar')->setText('<h2>Dresscode template</h2>'));
        $this->_addContent($this->getLayout()->createBlock('dresscodeconfig/adminhtml_installtemplate_edit'));
        $this->renderLayout();
	}

	public function dispatchAction()
    {
        $store = $this->getRequest()->getParam('store', 0);
        $action = $this->getRequest()->getParam('action', 'install');
        $this->getResponse()->setRedirect($this->getUrl("*/*/".$action."/store/".$store));

    }

    public function installAction()
    {
        $store = $this->getRequest()->getParam('store', 0);
        if(Mage::getStoreConfig('design/theme/default')!='dresscode') $this->_saveOldSettings($store);
        Mage::getModel('dresscodeconfig/content')->installTemplateResources($store);
        Mage::getModel('dresscodeconfig/content')->installTemplateBlocks($store);
        Mage::getModel('dresscodeconfig/content')->installTemplateConfig($store);
        Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('dresscodeconfig')->__('Dresscode Template installed successfully. If you do not see the changes please clean the cache.'));
        $this->getResponse()->setRedirect($this->getUrl("*/*/"));
    }

    public function uninstallAction()
    {
        $store = $this->getRequest()->getParam('store', 0);
        $file_config=Mage::getBaseDir().'/app/code/local/Etheme/Dresscodeconfig/Model/oldConfig.csv';
        $mage_csv = new Varien_File_Csv();
        $oldConfigData=$mage_csv->getData($file_config);

        $scope=($store ? 'stores' : 'default');
        Mage::getConfig()->saveConfig('design/theme/default', $oldConfigData[0][0], $scope, $store);
        Mage::getConfig()->saveConfig('web/default/cms_home_page', $oldConfigData[0][1], $scope, $store);
        Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('dresscodeconfig')->__('Dresscode Template uninstalled successfully. If you do not see the changes please clean the cache.'));
        $this->getResponse()->setRedirect($this->getUrl("*/*/"));
    }

    public function resetAction()
    {
        $this->_resetNode('mainfront');
        $this->_resetNode('socials');
        $this->_resetNode('productlabels');
        Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('dresscodeconfig')->__('Dresscode Theme Settings has been restored. If you do not see the changes please clean the cache.'));
        $this->getResponse()->setRedirect($this->getUrl("*/*/"));
    }

    protected function _saveOldSettings(int $store)
    {
        $file_config=Mage::getBaseDir().'/app/code/local/Etheme/Dresscodeconfig/Model/oldConfig.csv';
        $row=array();
        $data = array();
        $mage_csv = new Varien_File_Csv();
        $data['design/theme/default']      = (Mage::getStoreConfig('design/theme/default',1)!="") ? Mage::getStoreConfig('design/theme/default',1) : "default";
        $data['web/default/cms_home_page'] = Mage::getStoreConfig('web/default/cms_home_page',$store);
        $row[] = $data;
        $mage_csv->saveData($file_config, $row);

    }

    protected function _resetNode($xpath)
    {
        $store = $this->getRequest()->getParam('store', 0);
        $scope = $store ? 'stores' : 'default';
        $tpl_settings_def = new Varien_Simplexml_Config();
        $tpl_settings_def->loadFile(Mage::getBaseDir().'/app/code/local/Etheme/Dresscodeconfig/etc/config.xml');
        $sets=$tpl_settings_def->getNode('default/dresscodeconfig/dresscodeconfig_'.$xpath)->children();
        foreach ($sets as $item) Mage::getConfig()->saveConfig('dresscodeconfig/dresscodeconfig_'.$xpath.'/'.$item->getName(), (string)$item, $scope, $store);
    }
}



