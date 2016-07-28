<?php

class Pixel_Meetlive_Block_Meetlive extends Mage_Core_Block_Template {

    public function _prepareLayout() {
        return parent::_prepareLayout();
    }

    public function getMeetlive() {
        if (!$this->hasData('meetlive')) {
            $this->setData('meetlive', Mage::registry('meetlive'));
        }
        return $this->getData('meetlive');
    }

}