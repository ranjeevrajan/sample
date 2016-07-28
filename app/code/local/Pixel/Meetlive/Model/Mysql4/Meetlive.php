<?php

class Pixel_Meetlive_Model_Mysql4_Meetlive extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the meetlive_id refers to the key field in your database table.
        $this->_init('meetlive/meetlive', 'meetlive_id');
    }
}