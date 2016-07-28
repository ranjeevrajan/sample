<?php

class Pixel_Meetlive_Model_Mysql4_Meetlive_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract {

    public function _construct() {
        parent::_construct();
        $this->_init('meetlive/meetlive');
    }

}