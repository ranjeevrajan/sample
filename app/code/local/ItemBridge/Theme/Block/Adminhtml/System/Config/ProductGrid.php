<?php

/**
 * System Configuration layout
 *
 * @category    ItemBridge
 * @package     ItemBridge_Theme
 * @copyright   Copyright (c) 2013 InfoStyle (http://infostyle.com.ua)
 * @license     http://themeforest.net/licenses/regular_extended ThemeForest Regular & Extended License
 */

class ItemBridge_Theme_Block_Adminhtml_System_Config_ProductGrid extends Mage_Adminhtml_Block_System_Config_Form_Field
{
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        $element->setType('hidden');
        $grid_type = Mage::getStoreConfig("ib_theme_design/general/store_productGrid");

        $html = '<div style="overflow: hidden;">';
        $html .= '<select onchange="changeGrid(this)">';
        if ($grid_type == 'type1') {
            $html .= '<option value="type1">Type 1</option>';
            $html .= '<option value="type2">Type 2</option>';
        } else {
            $html .= '<option value="type2">Type 2</option>';
            $html .= '<option value="type1">Type 1</option>';
        }
        $html .= '</select>';
        $html .= '</div>';

        $script = '<script>';
        $script .= 'function changeGrid(layout){
        	document.getElementById("ib_theme_design_general_store_productGrid").value = layout.value;
        }';
        $script .= '</script>';

        return $element->getElementHtml() . $html . $script;
    }
}