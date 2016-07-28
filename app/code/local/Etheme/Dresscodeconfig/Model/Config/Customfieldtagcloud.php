<?php
/**
 * @version   1.0 14.08.2012
 * @author    TonyEcommerce http://www.TonyEcommerce.com <support@TonyEcommerce.com>
 * @copyright Copyright (c) 2012 TonyEcommerce
 */

class Etheme_Dresscodeconfig_Model_Config_Customfieldtagcloud
{

    public function toOptionArray()
    {
        return array(
            array('value'=>'usual','label' => Mage::helper('dresscodeconfig')->__('Usual')),
            array( 'value'=>'flash', 'label' => Mage::helper('dresscodeconfig')->__('Flash')),
        );
    }

}
