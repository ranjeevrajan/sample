<?php

class Offi_CustomerAttribute_Block_Adminhtml_Edit_Tab_Main extends Mage_Adminhtml_Block_Widget_Form {

    protected function _prepareForm() {
        $model = Mage::registry('entity_attribute');

        $form = new Varien_Data_Form(array(
            'id' => 'edit_form',
            'action' => $this->getData('action'),
            'method' => 'post',
            'enctype' => 'multipart/form-data'
        ));

        $fieldset = $form->addFieldset('base_fieldset', array('legend' => Mage::helper('customerattribute')->__('Attribute Properties'))
        );
        if ($model->getId()) {
            $fieldset->addField('attribute_id', 'hidden', array(
                'name' => 'attribute_id',
            ));
        }

        $this->_addElementTypes($fieldset);

        $yesno = array(
            array(
                'value' => 0,
                'label' => Mage::helper('customerattribute')->__('No')
            ),
            array(
                'value' => 1,
                'label' => Mage::helper('customerattribute')->__('Yes')
        ));

        $fieldset->addField('attribute_code', 'text', array(
            'name' => 'attribute_code',
            'label' => Mage::helper('customerattribute')->__('Attribute Code'),
            'title' => Mage::helper('customerattribute')->__('Attribute Code'),
            'note' => Mage::helper('customerattribute')->__('For internal use. Must be unique with no spaces'),
            'class' => 'validate-code',
            'required' => true,
        ));

        $scopes = array(
            Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE => Mage::helper('customerattribute')->__('Store View'),
            Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_WEBSITE => Mage::helper('customerattribute')->__('Website'),
            Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL => Mage::helper('customerattribute')->__('Global'),
        );

        if ($model->getAttributeCode() == 'status' || $model->getAttributeCode() == 'tax_class_id') {
            unset($scopes[Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE]);
        }

        $fieldset->addField('is_global', 'select', array(
            'name' => 'is_global',
            'label' => Mage::helper('customerattribute')->__('Scope'),
            'title' => Mage::helper('customerattribute')->__('Scope'),
            'note' => Mage::helper('customerattribute')->__('Declare attribute value saving scope'),
            'values' => $scopes
        ));

        $inputTypes = array(
            array(
                'value' => 'text',
                'label' => Mage::helper('customerattribute')->__('Text Field')
            ),
            /* array(
              'value' => 'textarea',
              'label' => Mage::helper('customerattribute')->__('Text Area')
              ),
              array(
              'value' => 'date',
              'label' => Mage::helper('customerattribute')->__('Date')
              ),
              array(
              'value' => 'boolean',
              'label' => Mage::helper('customerattribute')->__('Yes/No')
              ),
              array(
              'value' => 'multiselect',
              'label' => Mage::helper('customerattribute')->__('Multiple Select')
              ), */
            array(
                'value' => 'select',
                'label' => Mage::helper('customerattribute')->__('Dropdown')
            ),
        );
        /* if ($this->getRequest()->getParam('type') === "catalog_category") {
          $inputTypes[] = array(
          'value' => 'image',
          'label' => Mage::helper('customerattribute')->__('Image')
          );
          } */

        $response = new Varien_Object();
        $response->setTypes(array());
        //Mage::dispatchEvent('adminhtml_product_attribute_types', array('response'=>$response));

        $_disabledTypes = array();
        $_hiddenFields = array();
        foreach ($response->getTypes() as $type) {
            $inputTypes[] = $type;
            if (isset($type['hide_fields'])) {
                $_hiddenFields[$type['value']] = $type['hide_fields'];
            }
            if (isset($type['disabled_types'])) {
                $_disabledTypes[$type['value']] = $type['disabled_types'];
            }
        }
        Mage::register('attribute_type_hidden_fields', $_hiddenFields);
        Mage::register('attribute_type_disabled_types', $_disabledTypes);


        $fieldset->addField('frontend_input', 'select', array(
            'name' => 'frontend_input',
            'label' => Mage::helper('customerattribute')->__('Input Type for Store Owner'),
            'title' => Mage::helper('customerattribute')->__('Input Type for Store Owner'),
            'value' => 'text',
            'values' => $inputTypes
        ));
        /*         * **** champs cach�s dans le formulaire ********* */
        $fieldset->addField('entity_type_id', 'hidden', array(
            'name' => 'entity_type_id',
            'value' => Mage::getModel('eav/entity')->setType('Customer')->getTypeId()
        ));



        $fieldset->addField('is_user_defined', 'hidden', array(
            'name' => 'is_user_defined',
            'value' => 1
        ));

        $fieldset->addField('attribute_set_id', 'hidden', array(
            'name' => 'attribute_set_id',
            'value' => Mage::getModel('eav/entity')->setType('Customer')->getTypeId()
        ));

        $fieldset->addField('attribute_group_id', 'hidden', array(
            'name' => 'attribute_group_id',
            'value' => Mage::getModel('eav/entity')->setType('Customer')->getTypeId()
        ));

        /*         * **************************************************** */
        $fieldset->addField('is_unique', 'select', array(
            'name' => 'is_unique',
            'label' => Mage::helper('customerattribute')->__('Unique Value'), //orig:Unique Value
            'title' => Mage::helper('customerattribute')->__('Unique Value'), //orig:Unique Value
            'values' => $yesno,
        ));

        $fieldset->addField('is_required', 'select', array(
            'name' => 'is_required',
            'label' => Mage::helper('customerattribute')->__('Values Required'),
            'title' => Mage::helper('customerattribute')->__('Values Required'),
            'values' => $yesno,
        ));

        $fieldset->addField('frontend_class', 'select', array(
            'name' => 'frontend_class',
            'label' => Mage::helper('customerattribute')->__('Input Validation for Store Owner'),
            'title' => Mage::helper('customerattribute')->__('Input Validation for Store Owner'),
            'values' => array(
                array(
                    'value' => '',
                    'label' => Mage::helper('customerattribute')->__('None')
                ),
                array(
                    'value' => 'validate-number',
                    'label' => Mage::helper('customerattribute')->__('Decimal Number')
                ),
                array(
                    'value' => 'validate-digits',
                    'label' => Mage::helper('customerattribute')->__('Integer Number')
                ),
                array(
                    'value' => 'validate-email',
                    'label' => Mage::helper('customerattribute')->__('Email')
                ),
                array(
                    'value' => 'validate-url',
                    'label' => Mage::helper('customerattribute')->__('Url')
                ),
                array(
                    'value' => 'validate-alpha',
                    'label' => Mage::helper('customerattribute')->__('Letters')
                ),
                array(
                    'value' => 'validate-alphanum',
                    'label' => Mage::helper('customerattribute')->__('Letters(a-zA-Z) or Numbers(0-9)')
                ),
            )
        ));

        /*
          // frontend properties fieldset
          $fieldset = $form->addFieldset('front_fieldset', array('legend' => Mage::helper('customerattribute')->__('Frontend Properties')));

          $fieldset->addField('position', 'text', array(
          'name' => 'position',
          'label' => Mage::helper('customerattribute')->__('Position'),
          'title' => Mage::helper('customerattribute')->__('Position'),
          'note' => Mage::helper('customerattribute')->__('Position of attribute'),
          'class' => 'validate-digits',
          'value' => $model->getPosition()
          ));
         */

        /*
          $fieldset->addField('sort_order', 'text', array(
          'name' => 'sort_order',
          'label' => Mage::helper('customerattribute')->__('Order'),
          'title' => Mage::helper('customerattribute')->__('Order in form'),
          'note' => Mage::helper('customerattribute')->__('order of attribute in form edit/create. Leave blank for form bottom.'),
          'class' => 'validate-digits',
          'value' => $model->getAttributeSetInfo()
          ));
         */

        //Add to form 
        $fieldset = $form->addFieldset('used_in_forms', array('legend' => Mage::helper('customerattribute')->__('Used in forms')));

        $fieldset->addField('adminhtml_customer', 'checkbox', array(
            'label' => Mage::helper('customerattribute')->__('Admin customer'),
            'checked' => (is_array($model->getUsedInForms()) && in_array('adminhtml_customer', $model->getUsedInForms()) ? true : false),
            'name' => 'used_in_forms[]',
            'class' => 'attribute-checkbox',
            'value' => 'adminhtml_customer',
        ));

        $fieldset->addField('customer_account_create', 'checkbox', array(
            'label' => Mage::helper('customerattribute')->__('Customer Account Create'),
            'checked' => (is_array($model->getUsedInForms()) && in_array('customer_account_create', $model->getUsedInForms()) ? true : false),
            'name' => 'used_in_forms[]',
            'class' => 'attribute-checkbox',
            'value' => 'customer_account_create',
            'disabled' => 'disabled'
        ));

        $fieldset->addField('customer_account_edit', 'checkbox', array(
            'label' => Mage::helper('customerattribute')->__('Customer Account Edit'),
            'checked' => (is_array($model->getUsedInForms()) && in_array('customer_account_edit', $model->getUsedInForms()) ? true : false),
            'name' => 'used_in_forms[]',
            'class' => 'attribute-checkbox',
            'value' => 'customer_account_edit',
            'disabled' => 'disabled'
        ));

        $fieldset->addField('checkout_register', 'checkbox', array(
            'label' => Mage::helper('customerattribute')->__('Checkout Register'),
            'checked' => (is_array($model->getUsedInForms()) && in_array('checkout_register', $model->getUsedInForms()) ? true : false),
            'name' => 'used_in_forms[]',
            'class' => 'attribute-checkbox',
            'value' => 'checkout_register',
            'disabled' => 'disabled'
        ));


        //Adding custom informations metadata 
        $collection1 = Mage::registry('metadata_info');
        $model_data1 = new Varien_Object();
        $model_data1->setData('');
        foreach ($collection1 as $data1) {
            $model_data1 = $data1;
        }

        $image_path = $model_data1->getData('image') ? 'bodymeasurement/' . $model_data1->getData('image') : '';
        $image_path1 = $model_data1->getData('shape_type_1') ? 'bodymeasurement/bodyshape/' . $model_data1->getData('shape_type_1') : '';
        $image_path2 = $model_data1->getData('shape_type_2') ? 'bodymeasurement/bodyshape/' . $model_data1->getData('shape_type_2') : '';
        $image_path3 = $model_data1->getData('shape_type_3') ? 'bodymeasurement/bodyshape/' . $model_data1->getData('shape_type_3') : '';


        //Adding custom informations metadata
        $fieldset = $form->addFieldset('attribute_metadata', array('legend' => Mage::helper('customerattribute')->__('Additional Information')));

        $fieldset->addField('is_body_shape', 'select', array(
            'name' => 'is_body_shape',
            'label' => Mage::helper('customerattribute')->__('Is Body Shape'),
            'title' => Mage::helper('customerattribute')->__('Is Body Shape'),
            'values' => $yesno,
            'value' => $model_data1->getData('is_body_shape')
        ));
        
        $fieldset->addField('sort_order', 'text', array(
            'label' => Mage::helper('customerattribute')->__('Sort Order'),
            'required' => false,
            'height' => '50px',
            'width' => '50px',
            'name' => 'sort_order',
            'after_element_html' => '</br/><span class="hint">( Use integer values )',
            'value' => $model_data1->getData('sort_order')
        ));
        
        $fieldset->addField('blog_thumbnail', 'file', array(
            'label' => Mage::helper('customerattribute')->__('Thumbnail'),
            'required' => false,
            'height' => '50px',
            'width' => '50px',
            'name' => 'blog_thumbnail',
            'after_element_html' => '</br/><span class="hint">( Allowed file extensions are : mp4,flv )</span><br/>Selected File : ' . $image_path,
            'value' => $image_path
        ));

        ///////Shape type label and images
        /* $fieldset->addField('shape_label_1', 'text', array(
          'label' => Mage::helper('customerattribute')->__('Shape label 1'),
          'name' => 'shape_label_1',
          'class' => '',
          'value' => $model_data1->getData('shape_label_1')
          )); */
        $fieldset->addField('shape_type_1', 'image', array(
            'label' => Mage::helper('customerattribute')->__('Shape type 1'),
            'required' => false,
            'height' => '50px',
            'width' => '50px',
            'name' => 'shape_type_1',
            'after_element_html' => '<span class="hint">( Allowed file extensions are : jpg , jpeg , gif , png )</span>',
            'value' => $image_path1
        ));


        /* $fieldset->addField('shape_label_2', 'text', array(
          'label' => Mage::helper('customerattribute')->__('Shape label 2'),
          'name' => 'shape_label_2',
          'class' => '',
          'value' => $model_data1->getData('shape_label_2')
          )); */
        $fieldset->addField('shape_type_2', 'image', array(
            'label' => Mage::helper('customerattribute')->__('Shape type 2'),
            'required' => false,
            'height' => '50px',
            'width' => '50px',
            'name' => 'shape_type_2',
            'after_element_html' => '<span class="hint">( Allowed file extensions are : jpg , jpeg , gif , png )</span>',
            'value' => $image_path2
        ));


        /* $fieldset->addField('shape_label_3', 'text', array(
          'label' => Mage::helper('customerattribute')->__('Shape label 3'),
          'name' => 'shape_label_3',
          'class' => '',
          'value' => $model_data1->getData('shape_label_3')
          )); */
        $fieldset->addField('shape_type_3', 'image', array(
            'label' => Mage::helper('customerattribute')->__('Shape type 3'),
            'required' => false,
            'height' => '50px',
            'width' => '50px',
            'name' => 'shape_type_3',
            'after_element_html' => '<span class="hint">( Allowed file extensions are : jpg , jpeg , gif , png )</span>',
            'value' => $image_path3
        ));
        ///////Shape type images

        $fieldset->addField('short_description', 'textarea', array(
            'label' => Mage::helper('customerattribute')->__('Short Description'),
            'name' => 'short_description',
            'class' => '',
            'value' => $model_data1->getData('short_description')
        ));

        //Added description area
        $descriptions = $fieldset->addField('descriptions', 'text', array(
            'label' => Mage::helper('customerattribute')->__('Description'),
            'name' => 'descriptions'
        ));
        $descriptions_model = Mage::getModel('customerattribute/descriptions')->setData('attribute_metadata', $model_data1);
        $descriptions->setRenderer($this->getLayout()->createBlock('customerattribute/adminhtml_edit_tab_main_descriptions')->setData('descriptions_model', $descriptions_model));

        if ($model->getId()) {
            $form->getElement('attribute_code')->setDisabled(1);
            $form->getElement('frontend_input')->setDisabled(1);

            if (isset($disableAttributeFields[$model->getAttributeCode()])) {
                foreach ($disableAttributeFields[$model->getAttributeCode()] as $field) {
                    $form->getElement($field)->setDisabled(1);
                }
            }
        }

        $form->addValues($model->getData());



        $this->setForm($form);

        return parent::_prepareForm();
    }

}
