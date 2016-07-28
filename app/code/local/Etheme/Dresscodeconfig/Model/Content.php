<?php
/**
 * @version   1.0 14.08.2012
 * @author    TonyEcommerce http://www.TonyEcommerce.com <support@TonyEcommerce.com>
 * @copyright Copyright (c) 2012 TonyEcommerce
 */

class Etheme_Dresscodeconfig_Model_Content extends Mage_Core_Model_Abstract
{
    protected $data_resources_xml;
    protected $data_static_blocks_xml;

    public function __construct()
    {
        parent::__construct();
        $this->data_resources_xml = new Varien_Simplexml_Config(Mage::getBaseDir().'/app/code/local/Etheme/Dresscodeconfig/Model/data_resources.xml');
        $this->data_static_blocks_xml = new Varien_Simplexml_Config(Mage::getBaseDir().'/app/code/local/Etheme/Dresscodeconfig/Model/data_static_blocks.xml');
    }

    public function installTemplateConfig(int $store)
    {
        $scope=($store ? 'stores' : 'default');
        Mage::getConfig()->saveConfig('design/theme/default', 'dresscode', $scope, $store);
        Mage::getConfig()->saveConfig('web/default/cms_home_page', 'dresscode_home', $scope, $store);
    }

    public function installTemplateResources(int $store)
    {
        foreach ($this->data_resources_xml->getNode('resources')->children() as $resource )
        {
            $data = array();
            foreach ($resource as $param) $data[$param->getName()]=(string)$param;
            $data['stores']=array();
            $data['stores'][] = $store;
            $exist = Mage::getModel('cms/page')->getCollection()->addFieldToFilter('identifier', array( 'eq' => $data['identifier']))->load();
            if (!count($exist)) Mage::getModel('cms/page')->setData($data)->save();
        }
    }

    public function installTemplateBlocks(int $store)
    {
        foreach ($this->data_static_blocks_xml->getNode('blocks')->children() as $resource )
        {
            $data = array();
            foreach ($resource as $param) $data[$param->getName()]=(string)$param;
            $data['stores']=array();
            $data['stores'][] = $store;
            $exist = Mage::getModel('cms/block')->getCollection()->addFieldToFilter('identifier', array( 'eq' => $data['identifier']))->load();
            if (!count($exist)) Mage::getModel('cms/block')->setData($data)->save();
        }
    }

}
