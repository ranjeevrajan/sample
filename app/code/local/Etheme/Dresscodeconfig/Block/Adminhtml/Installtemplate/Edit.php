<?php
/**
 * @version   1.0 14.08.2012
 * @author    TonyEcommerce http://www.TonyEcommerce.com <support@TonyEcommerce.com>
 * @copyright Copyright (c) 2012 TonyEcommerce
 */

class Etheme_Dresscodeconfig_Block_Adminhtml_Installtemplate_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
        $this->_controller = 'adminhtml_installtemplate';
        $this->_blockGroup = 'dresscodeconfig';
        $this->_updateButton('save', 'label', Mage::helper('dresscodeconfig')->__('Submit Action'));
        $this->_removeButton('back');    
    }

    public function getHeaderText()
    {
        return Mage::helper('dresscodeconfig')->__('Install / Uninstall / Reset Dresscode Template');
    }
}
