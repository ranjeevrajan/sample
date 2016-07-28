<?php
/**
 * @version   1.0 14.08.2012
 * @author    TonyEcommerce http://www.TonyEcommerce.com <support@TonyEcommerce.com>
 * @copyright Copyright (c) 2012 TonyEcommerce
 */

class Etheme_Dresscodeslider_Block_Dresscodeslider extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }

	public function getDataSlides()
    {
        $data_slides  = Mage::getModel('dresscodeslider/dresscodeslider')->getCollection()
        	->addFieldToSelect('*')
        	->addFieldToFilter('status', 1);
        return $data_slides;
    }

    public function getDataSlider()
    {
        if (!$this->hasData('dresscodeslider'))$this->setData('dresscodeslider', Mage::registry('dresscodeslider'));
        else return $this->getData('dresscodeslider');

    }

}