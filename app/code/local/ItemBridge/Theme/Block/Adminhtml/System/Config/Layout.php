<?php

/**
 * System Configuration layout
 *
 * @category    ItemBridge
 * @package     ItemBridge_Theme
 * @copyright   Copyright (c) 2013 InfoStyle (http://infostyle.com.ua)
 * @license     http://themeforest.net/licenses/regular_extended ThemeForest Regular & Extended License
 */

class ItemBridge_Theme_Block_Adminhtml_System_Config_Layout extends Mage_Adminhtml_Block_System_Config_Form_Field
{
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        $element->setType('hidden');
        $layout = Mage::getStoreConfig("ib_theme_design/general/store_layout");

        $html = '<div style="overflow: hidden;">';
        $html .= '<select onchange="changeLayout(this)">';
        $html .= '<option>' . $layout . '</option>';
        $html .= '<option value="standart">standart</option>';
        $html .= '<option value="boxed">boxed</option>';
        $html .= '<option value="wide">wide</option>';
        $html .= '</select>';
        $html .= '</div>';

        $script = '<script>';
        $script .= 'function changeLayout(layout){
        	document.getElementById("ib_theme_design_general_store_layout").value = layout.value;
        }';
        $script .= '</script>';

        return $element->getElementHtml() . $html . $script;
    }
}