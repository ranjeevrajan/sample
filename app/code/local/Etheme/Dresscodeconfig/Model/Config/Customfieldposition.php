<?php
/**
 * @version   1.0 14.08.2012
 * @author    TonyEcommerce http://www.TonyEcommerce.com <support@TonyEcommerce.com>
 * @copyright Copyright (c) 2012 TonyEcommerce
 */

class etheme_dresscodeconfig_Model_Config_Customfieldposition
{

    public function toOptionArray()
    {
        return array(
            array('value'=>'top_left','label' => Mage::helper('dresscodeconfig')->__('Top Left')),
            array( 'value'=>'top_right', 'label' => Mage::helper('dresscodeconfig')->__('Top Right')),
            array( 'value'=>'bottom_left','label' => Mage::helper('dresscodeconfig')->__('Bottom Left')),
            array( 'value'=>'bottom_right', 'label' => Mage::helper('dresscodeconfig')->__('Bottom Right')),
        );
    }

}
