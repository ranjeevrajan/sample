<?php
/**
 * @version   1.0 14.08.2012
 * @author    TonyEcommerce http://www.TonyEcommerce.com <support@TonyEcommerce.com>
 * @copyright Copyright (c) 2012 TonyEcommerce
 */

class Etheme_Dresscodeconfig_Model_Config_Customfieldpattern
{

    public function toOptionArray()
    {
        return array(
            array('value'=>'bg_pattern_01','label' => Mage::helper('dresscodeconfig')->__('Pattern 1')),
            array('value'=>'bg_pattern_02','label' => Mage::helper('dresscodeconfig')->__('Pattern 2')),
            array('value'=>'bg_pattern_03','label' => Mage::helper('dresscodeconfig')->__('Pattern 3')),
            array('value'=>'bg_pattern_04','label' => Mage::helper('dresscodeconfig')->__('Pattern 4')),
            array('value'=>'bg_pattern_05','label' => Mage::helper('dresscodeconfig')->__('Pattern 5')),
            array('value'=>'bg_pattern_06','label' => Mage::helper('dresscodeconfig')->__('Pattern 6')),
            array('value'=>'bg_pattern_07','label' => Mage::helper('dresscodeconfig')->__('Pattern 7')),
            array('value'=>'bg_pattern_08','label' => Mage::helper('dresscodeconfig')->__('Pattern 8')),
			array('value'=>'spacer',       'label' => Mage::helper('dresscodeconfig')->__('Without pattern')),
        );
    }

}
