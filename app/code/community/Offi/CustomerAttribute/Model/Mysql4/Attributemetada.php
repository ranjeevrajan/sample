<?php

class Offi_CustomerAttribute_Model_Mysql4_Attributemetada extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the metadata_id refers to the key field in your database table.
        $this->_init('customerattribute/attributemetada', 'metadata_id');
    }
}