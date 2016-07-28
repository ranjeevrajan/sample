<?php

class Offi_CustomerAttribute_Adminhtml_IndexController extends Mage_Adminhtml_Controller_Action {

    protected $_entityTypeId;

    public function preDispatch() {
        parent::preDispatch();
        $this->_entityTypeId = Mage::getModel('eav/entity')->setType('Customer')->getTypeId();
    }

    protected function _initAction() {
        $this->loadLayout()
                ->_setActiveMenu('customer/customer')
                ->_addBreadcrumb(Mage::helper('adminhtml')->__('Customer Attributes Manager'), Mage::helper('adminhtml')->__('Customer Attributes Manager'));
        return $this;
    }

    public function indexAction() {
        $this->_initAction()->_addContent($this->getLayout()->createBlock('customerattribute/adminhtml_Grid'));
        $this->renderLayout();
    }

    public function newAction() {
        $this->_forward('edit');
    }

    public function editAction() {

        $this->loadLayout();
        $id = $this->getRequest()->getParam('attribute_id');
        $model = Mage::getModel('eav/entity_attribute');

        //Custom metadata
        $model1 = Mage::getModel('customerattribute/attributemetada');

        if ($id) {
            $model->load($id);

            if (!$model->getId()) {
                Mage::getSingleton('adminhtml/session')->addError(
                        Mage::helper('customerattribute')->__('This attribute no longer exists'));
                $this->_redirect('*/*/');
                return;
            }

            // entity type check
            if ($model->getEntityTypeId() != $this->_entityTypeId) {
                Mage::getSingleton('adminhtml/session')->addError(
                        Mage::helper('customerattribute')->__('This attribute cannot be edited.'));
                $this->_redirect('*/*/');
                return;
            }

            //get Used in forms
            $config = Mage::getSingleton('eav/config')
                    ->getAttribute('customer', $model->getAttributeCode());
            $model->addData(array('used_in_forms' => $config->getUsedInForms()));
        }

        // set entered data if was error when we do save
        $data = Mage::getSingleton('adminhtml/session')->getAttributeData(true);

        if (!empty($data)) {
            $model->addData($data);
        }

        //Custom metadata
        $collection1 = $model1->getCollection()->addFieldToFilter('attribute_id', array('eq' => $model->getId()));
        $collection1->getSelect()->distinct();
        Mage::register('metadata_info', $collection1);


        Mage::register('entity_attribute', $model);

        $this->_initAction();

        $this->_title($id ? $model->getName() : $this->__('New Attribute'));

        $item = $id ? Mage::helper('customerattribute')->__('Edit Customer Attribute') : Mage::helper('customerattribute')->__('New Customer Attribute');

        $this->_addBreadcrumb($item, $item);

        //$this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

        $this
                ->_addContent($this->getLayout()->createBlock('customerattribute/adminhtml_edit'))
                ->_addLeft($this->getLayout()->createBlock('customerattribute/adminhtml_edit_tabs'))
        ;



        $this->renderLayout();
    }

    public function validateAction() {
        $response = new Varien_Object();
        $response->setError(false);
        $attributeCode = $this->getRequest()->getParam('attribute_code');
        $attributeId = $this->getRequest()->getParam('attribute_id');
        $attribute = Mage::getModel('eav/entity_attribute')
                ->loadByCode($this->_entityTypeId, $attributeCode);


        if ($attribute->getId() && !$attributeId) {
            Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('customerattribute')->__('Attribute with the same code already exists'));
            $this->_initLayoutMessages('adminhtml/session');
            $response->setError(true);
            $response->setMessage($this->getLayout()->getMessagesBlock()->getGroupedHtml());
        }

        $this->getResponse()->setBody($response->toJson());
    }

    public function saveAction() {

        $data = $this->getRequest()->getPost();

        if ($data) {
            /** @var $session Mage_Admin_Model_Session */
            $session = Mage::getSingleton('adminhtml/session');

            $redirectBack = $this->getRequest()->getParam('back', false);
            /* @var $model Mage_Catalog_Model_Entity_Attribute */
            $model = Mage::getModel('customerattribute/customerattribute');
            /* @var $helper Mage_Catalog_Helper_Product */
            $helper = Mage::helper('customerattribute');

            $id = $this->getRequest()->getParam('attribute_id');

            //validate attribute_code
            if (isset($data['attribute_code'])) {
                $validatorAttrCode = new Zend_Validate_Regex(array('pattern' => '/^[a-z_]{1,255}$/'));
                if (!$validatorAttrCode->isValid($data['attribute_code'])) {
                    $session->addError(
                            $helper->__('Attribute code is invalid. Please use only letters (a-z), numbers (0-9) or underscore(_) in this field, first character should be a letter.'));
                    $this->_redirect('*/*/edit', array('attribute_id' => $id, '_current' => true));
                    return;
                }
            }


            //validate frontend_input
            if (isset($data['frontend_input'])) {
                /** @var $validatorInputType Mage_Eav_Model_Adminhtml_System_Config_Source_Inputtype_Validator */
                $validatorInputType = Mage::getModel('eav/adminhtml_system_config_source_inputtype_validator');
                if (!$validatorInputType->isValid($data['frontend_input'])) {
                    foreach ($validatorInputType->getMessages() as $message) {
                        $session->addError($message);
                    }
                    $this->_redirect('*/*/edit', array('attribute_id' => $id, '_current' => true));
                    return;
                }
            }

            if ($id) {
                $model->load($id);

                if (!$model->getId()) {
                    $session->addError(
                            Mage::helper('customerattribute')->__('This Attribute no longer exists'));
                    $this->_redirect('*/*/');
                    return;
                }

                // entity type check
                if ($model->getEntityTypeId() != $this->_entityTypeId) {
                    $session->addError(
                            Mage::helper('customerattribute')->__('This attribute cannot be updated.'));
                    $session->setAttributeData($data);
                    $this->_redirect('*/*/');
                    return;
                }

                $data['attribute_code'] = $model->getAttributeCode();
                $data['is_user_defined'] = $model->getIsUserDefined();
                $data['frontend_input'] = $model->getFrontendInput();
            } else {
                /**
                 * @todo add to helper and specify all relations for properties
                 */
                $data['source_model'] = $helper->getAttributeSourceModelByInputType($data['frontend_input']);
                $data['backend_model'] = $helper->getAttributeBackendModelByInputType($data['frontend_input']);
            }

            if (!isset($data['is_configurable'])) {
                $data['is_configurable'] = 0;
            }
            if (!isset($data['is_filterable'])) {
                $data['is_filterable'] = 0;
            }
            if (!isset($data['is_filterable_in_search'])) {
                $data['is_filterable_in_search'] = 0;
            }

            if (is_null($model->getIsUserDefined()) || $model->getIsUserDefined() != 0) {
                $data['backend_type'] = $model->getBackendTypeByInput($data['frontend_input']);
            }

            $defaultValueField = $model->getDefaultValueByInput($data['frontend_input']);
            if ($defaultValueField) {
                $data['default_value'] = $this->getRequest()->getParam($defaultValueField);
            }

            if (!isset($data['apply_to'])) {
                $data['apply_to'] = array();
            }

            //filter
            $data = $this->_filterPostData($data);

            $model->addData($data);

            if (!$id) {
                $model->setEntityTypeId($this->_entityTypeId);
                $model->setIsUserDefined(1);
            }


            if ($this->getRequest()->getParam('set') && $this->getRequest()->getParam('group')) {
                // For creating product attribute on product page we need specify attribute set and group
                $model->setAttributeSetId($this->getRequest()->getParam('set'));
                $model->setAttributeGroupId($this->getRequest()->getParam('group'));
            }

            try {
                $model->save();
                $used_in_forms = $this->getRequest()->getParam('used_in_forms');
                if ($model->getId() && is_array($used_in_forms)) {
                    Mage::getSingleton('eav/config')
                            ->getAttribute('customer', $model->getAttributeCode())
                            ->setData('used_in_forms', $used_in_forms)
                            ->save();
                }

                //Adding metadata into the custom table
                $model1_collection = Mage::getModel('customerattribute/attributemetada')->getCollection()
                        ->addFieldToFilter('attribute_id', array('eq' => $model->getId()));



                if (count($model1_collection) == 1) {
                    foreach ($model1_collection as $model1) {
                        //unlink prev image
                        if (isset($_FILES['blog_thumbnail']['name']) && $_FILES['blog_thumbnail']['name'] != '') {
                            $prev_file_val = $model1->getData('image');
                            $image_path = Mage::getBaseDir('media') . DS . 'bodymeasurement' . DS . $prev_file_val;
                            unlink($image_path);
                        }

                        //////unlink prev image same as above
                        for ($i = 1; $i <= 3; $i++) {
                            if (isset($_FILES["shape_type_$i"]['name']) && $_FILES["shape_type_$i"]['name'] != '') {
                                $prev_file_val = $model1->getData("shape_type_$i");
                                $image_path = Mage::getBaseDir('media') . DS . 'bodymeasurement' . DS . 'bodyshape' . DS . $prev_file_val;
                                unlink($image_path);
                            }
                        }
                    }
                }




                if (isset($_FILES['blog_thumbnail']['name']) && $_FILES['blog_thumbnail']['name'] != '') {
                    try {
                        /* Starting upload */
                        $uploader = new Varien_File_Uploader('blog_thumbnail');

                        // Any extention would work
                        $uploader->setAllowedExtensions(array('jpg', 'jpeg', 'gif', 'png', 'flv', 'mp4'));
                        $uploader->setAllowRenameFiles(true);

                        // Set the file upload mode 
                        // false -> get the file directly in the specified folder
                        // true -> get the file in the product like folders 
                        // (file.jpg will go in something like /media/f/i/file.jpg)
                        $uploader->setFilesDispersion(false);

                        // We set media as the upload dir
                        $path = Mage::getBaseDir('media') . DS . 'bodymeasurement';
                        $uploader->save($path, $_FILES['blog_thumbnail']['name']);
                        //echo $uploader->getUploadedFileName();
                        //print_r(get_class_methods($uploader));die;
                    } catch (Exception $e) {
                        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('customerattribute')->__('Image is not saved.Choose allowed file extensions.'));
                        //$this->_redirect('*/*/edit', array('attribute_id' => $id, '_current' => true));
                    }

                    //this way the name is saved in DB
                    $data['blog_thumbnail'] = $_FILES['blog_thumbnail']['name'];
                } else {
                    $blog_thumbnail = $this->getRequest()->getParam('blog_thumbnail');

                    if ($blog_thumbnail['delete'] == 1) {
                        $prev_file_val = $data['blog_thumbnail']['value'];
                        //Unlink image
                        $image_path = Mage::getBaseDir('media') . DS . $prev_file_val;
                        unlink($image_path);
                    }
                }


                //Same above logic for shape type images
                $uploaded_file_name = array();
                for ($i = 1; $i <= 3; $i++) {
                    unset($uploader1);
                    if (isset($_FILES["shape_type_$i"]['name']) && $_FILES["shape_type_$i"]['name'] != '') {

                        try {
                            /* Starting upload */
                            $uploader1 = new Varien_File_Uploader("shape_type_$i");

                            // Any extention would work
                            $uploader1->setAllowedExtensions(array('jpg', 'jpeg', 'gif', 'png'));
                            $uploader1->setAllowRenameFiles(true);

                            // Set the file upload mode 
                            // false -> get the file directly in the specified folder
                            // true -> get the file in the product like folders 
                            // (file.jpg will go in something like /media/f/i/file.jpg)
                            $uploader1->setFilesDispersion(false);

                            // We set media as the upload dir
                            $path = Mage::getBaseDir('media') . DS . 'bodymeasurement' . DS . 'bodyshape';
                            $uploader1->save($path, $_FILES["shape_type_$i"]['name']);
                            $uploaded_file_name[$i] = $uploader1->getUploadedFileName();
                        } catch (Exception $e) {
                            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('customerattribute')->__('Image is not saved.Choose allowed file extensions.'));
                            //$this->_redirect('*/*/edit', array('attribute_id' => $id, '_current' => true));
                        }

                        //this way the name is saved in DB
                        $data["shape_type_$i"] = $_FILES["shape_type_$i"]['name'];
                    } else {
                        for ($i = 1; $i <= 3; $i++) {
                            $shape_type_1 = $this->getRequest()->getParam("shape_type_$i");
                            if ($shape_type_1['delete'] == 1) {
                                $prev_file_val = $data["shape_type_$i"]['value'];
                                $image_path = Mage::getBaseDir('media') . DS . $prev_file_val;
                                unlink($image_path);
                            }
                        }
                    }
                }
                //Same above logic for shape type images


                if (count($model1_collection) == 1) {
                    foreach ($model1_collection as $model1) {
                        if (isset($_FILES["blog_thumbnail"]['name']) && $_FILES["blog_thumbnail"]['name'] != '') {
                            $model1
                                    ->setData('image', $uploader->getUploadedFileName());
                        } elseif ($blog_thumbnail['delete'] == 1) {
                            $model1
                                    ->setData('image', '');
                        }

                        $model1->setData('short_description', $data['short_description']);

                        //////set body shape images and label data
                        for ($i = 1; $i <= 3; $i++) {
                            $shape_type_1 = $this->getRequest()->getParam("shape_type_$i");
                            if (isset($_FILES["shape_type_$i"]['name']) && $_FILES["shape_type_$i"]['name'] != '') {
                                //echo '===='."shape_type_$i"."==".$uploaded_file_name[$i];die;
                                $model1
                                        ->setData("shape_type_$i", $uploaded_file_name[$i]);
                            } elseif ($shape_type_1['delete'] == 1) {
                                $model1
                                        ->setData("shape_type_$i", '');
                            }
                            //$model1
                            //	->setData("shape_label_$i",$data["shape_label_$i"]);
                        }


                        if ($model1->getCreatedTime == NULL || $model1->getUpdateTime() == NULL) {
                            $model1->setCreatedTime(now())
                                    ->setUpdateTime(now());
                        } else {
                            $model1->setUpdateTime(now());
                        }
                    }
                } else {
                    $model1 = Mage::getModel('customerattribute/attributemetada');
                    $model1
                            ->setData('attribute_id', $model->getId())
                            ->setData('image', $data['blog_thumbnail'])
                            ->setData('short_description', $data['short_description']);

                    //////set body shape images and label data
                    for ($i = 1; $i <= 3; $i++) {
                        $model1
                                ->setData("shape_type_$i", $data["shape_type_$i"]);
                        //->setData("shape_label_$i",$data["shape_label_$i"]);
                    }

                    if ($model1->getCreatedTime == NULL || $model1->getUpdateTime() == NULL) {
                        $model1->setCreatedTime(now())
                                ->setUpdateTime(now());
                    } else {
                        $model1->setUpdateTime(now());
                    }
                }
                
                if(isset($data['sort_order'])) {
                    if(is_numeric($data['sort_order'])) {
                        $model1->setData('sort_order', $data['sort_order']);
                    } else{
                        $model1->setData('sort_order', 0);
                    }
                }
                
                if(isset($data['is_body_shape'])) {
                    $model1->setData('is_body_shape', $data['is_body_shape']);
                }
                
                $model1->setDescriptValues($data['description']);
                $model1->save();
                $session->addSuccess(
                        Mage::helper('customerattribute')->__('The customer attribute has been saved.'));

                
                //set description model
                $store_descriptions = $model1->getStoreDescriptions();
                $model2 = Mage::getModel('customerattribute/descriptions');
                $model2->setStoreDescriptions($store_descriptions);
                $model2->setAttributeId($model->getId());
                $model2->saveRow();
                
                /**
                 * Clear translation cache because attribute labels are stored in translation
                 */
                Mage::app()->cleanCache(array(Mage_Core_Model_Translate::CACHE_TAG));
                $session->setAttributeData(false);
                if ($this->getRequest()->getParam('popup')) {
                    $this->_redirect('adminhtml/catalog_product/addAttribute', array(
                        'id' => $this->getRequest()->getParam('product'),
                        'attribute' => $model->getId(),
                        '_current' => true
                    ));
                } elseif ($redirectBack) {
                    $this->_redirect('*/*/edit', array('attribute_id' => $model->getId(), '_current' => true));
                } else {
                    $this->_redirect('*/*/', array());
                }
                return;
            } catch (Exception $e) {
                $session->addError($e->getMessage());
                $session->setAttributeData($data);
                $this->_redirect('*/*/edit', array('attribute_id' => $id, '_current' => true));
                return;
            }
        }
        $this->_redirect('*/*/');
    }

    /**
     * Filter post data
     *
     * @param array $data
     * @return array
     */
    protected function _filterPostData($data) {
        if ($data) {
            /** @var $helperCatalog Mage_Catalog_Helper_Data */
            $helperCatalog = Mage::helper('customerattribute');
            //labels
            foreach ($data['frontend_label'] as & $value) {
                if ($value) {
                    $value = $helperCatalog->stripTags($value);
                }
            }
            //options
            if (!empty($data['option']['value'])) {
                foreach ($data['option']['value'] as &$options) {
                    foreach ($options as &$label) {
                        $label = $helperCatalog->stripTags($label);
                    }
                }
            }
            //default value
            if (!empty($data['default_value'])) {
                $data['default_value'] = $helperCatalog->stripTags($data['default_value']);
            }
            if (!empty($data['default_value_text'])) {
                $data['default_value_text'] = $helperCatalog->stripTags($data['default_value_text']);
            }
            if (!empty($data['default_value_textarea'])) {
                $data['default_value_textarea'] = $helperCatalog->stripTags($data['default_value_textarea']);
            }
        }
        return $data;
    }

    public function deleteAction() {
        if ($id = $this->getRequest()->getParam('attribute_id')) {
            $model = Mage::getModel('customerattribute/customerattribute');

            // entity type check
            $model->load($id);
            if ($model->getEntityTypeId() != $this->_entityTypeId) {
                Mage::getSingleton('adminhtml/session')->addError(
                        Mage::helper('customerattribute')->__('This attribute cannot be deleted.'));
                $this->_redirect('*/*/');
                return;
            }

            try {
                $model->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                        Mage::helper('customerattribute')->__('The customer attribute has been deleted.'));
                $this->_redirect('*/*/');
                return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('attribute_id' => $this->getRequest()->getParam('attribute_id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('customerattribute')->__('Unable to find an attribute to delete.'));
        $this->_redirect('*/*/');
    }

}
