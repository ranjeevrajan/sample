<?php
/**
 * System Configuration layout
 *
 * @category    ItemBridge
 * @package     ItemBridge_Theme
 * @copyright   Copyright (c) 2013 InfoStyle (http://infostyle.com.ua)
 * @license     http://themeforest.net/licenses/regular_extended ThemeForest Regular & Extended License
 */

class ItemBridge_Theme_Block_Adminhtml_System_Config_OptionsPanel extends Mage_Adminhtml_Block_System_Config_Form_Field
{
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        $element->setType('hidden');
        $grid_type = Mage::getStoreConfig("ib_theme_design/general/store_OptionsPanel");

        $html = '<div style="overflow: hidden;">';
        $html .= '<select onchange="changeGrid(this)">';
        if ($grid_type == 'yes') {
            $html .= '<option value="yes">Enable</option>';
            $html .= '<option value="no">Disable</option>';
        } else {
            $html .= '<option value="no">Disable</option>';
            $html .= '<option value="yes">Enable</option>';
        }
        $html .= '</select>';
        $html .= '</div>';

        $script = '<script>';
        $script .= 'function changeGrid(layout){
        	document.getElementById("ib_theme_design_general_store_OptionsPanel").value = layout.value;
        }';
        $script .= '</script>';

        return $element->getElementHtml() . $html . $script;
    }
}