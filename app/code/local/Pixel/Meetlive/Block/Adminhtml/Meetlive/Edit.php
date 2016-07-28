<?php

class Pixel_Meetlive_Block_Adminhtml_Meetlive_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'meetlive';
        $this->_controller = 'adminhtml_meetlive';
        
        $this->_updateButton('save', 'label', Mage::helper('meetlive')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('meetlive')->__('Delete Item'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('meetlive_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'meetlive_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'meetlive_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('meetlive_data') && Mage::registry('meetlive_data')->getId() ) {
            return Mage::helper('meetlive')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('meetlive_data')->getName()));
        } else {
            return Mage::helper('meetlive')->__('Add Item');
        }
    }
}