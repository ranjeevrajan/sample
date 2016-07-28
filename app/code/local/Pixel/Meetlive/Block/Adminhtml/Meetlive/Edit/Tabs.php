<?php

class Pixel_Meetlive_Block_Adminhtml_Meetlive_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs {

    public function __construct() {
        parent::__construct();
        $this->setId('meetlive_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('meetlive')->__('Item Information'));
    }

    protected function _beforeToHtml() {
        $this->addTab('form_section', array(
            'label' => Mage::helper('meetlive')->__('Item Information'),
            'title' => Mage::helper('meetlive')->__('Item Information'),
            'content' => $this->getLayout()->createBlock('meetlive/adminhtml_meetlive_edit_tab_form')->toHtml(),
        ));

        return parent::_beforeToHtml();
    }

}