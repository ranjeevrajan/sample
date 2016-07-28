<?php
/**
 * @author Abdullah
 */

class Offi_CustomerAttribute_Model_Mysql4_Descriptions extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {
        $this->_init('customerattribute/descriptions', 'description_label_id');
    }
}
