<?php

/**
 * System Configuration footer
 *
 * @category    ItemBridge
 * @package     ItemBridge_Theme
 * @copyright   Copyright (c) 2013 InfoStyle (http://infostyle.com.ua)
 * @license     http://themeforest.net/licenses/regular_extended ThemeForest Regular & Extended License
 */

class ItemBridge_Theme_Block_Adminhtml_System_Config_Footer extends Mage_Adminhtml_Block_System_Config_Form_Field
{
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        $element->setType('hidden');
        $footer = Mage::getStoreConfig("ib_theme_design/general/store_footer");

        $html = '<div style="overflow: hidden;">';
        $html .= '<select onchange="changeFooter(this)">';
        $html .= '<option>' . $footer . '</option>';
        $html .= '<option value="light">light</option>';
        $html .= '<option value="dark">dark</option>';
        $html .= '</select>';
        $html .= '</div>';

        $script = '<script>';
        $script .= 'function changeFooter(footer){
        	document.getElementById("ib_theme_design_general_store_footer").value = footer.value;
        }';
        $script .= '</script>';

        return $element->getElementHtml() . $html . $script;
    }
}