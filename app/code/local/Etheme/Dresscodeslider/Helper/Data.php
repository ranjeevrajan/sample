<?php
/**
 * @version   1.0 14.08.2012
 * @author    TonyEcommerce http://www.TonyEcommerce.com <support@TonyEcommerce.com>
 * @copyright Copyright (c) 2012 TonyEcommerce
 */

class Etheme_dresscodeslider_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function fileLoad($name, &$formData,$pathModule)
    {
        if(isset($_FILES[$name]['name']) && $_FILES[$name]['name'] != null)
        {
            $fileUploader = new Varien_File_Uploader($name);
            $fileUploader->setAllowedExtensions(array('jpg','jpeg','gif','png'));
            $fileUploader->setAllowRenameFiles(false);
            $fileUploader->setFilesDispersion(false);
            $path = Mage::getBaseDir('media') . DS.$pathModule.DS ;
            $fileUploader->save($path, $_FILES[$name]['name'] );
            $formData[$name] = $pathModule. '/' .$_FILES[$name]['name'];
        }
    }
}