<?php

class Offi_CustomerAttribute_Block_Adminhtml_Grid extends Mage_Adminhtml_Block_Widget_Grid {

    public function __construct() {
        parent::__construct();
        $this->setId('customerattributegrid');
        $this->setDefaultSort('attribute_code');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
        $this->setTemplate('customerattribute/grid.phtml');
    }

    protected function _prepareCollection() {
        $metadata_collection = Mage::getModel('customerattribute/attributemetada')->getCollection()
                ->addFieldToSelect('attribute_id');
        $attr_ids = array();
        $readonce = Mage::getSingleton('core/resource')->getConnection('core_read');
        $rows = $readonce->fetchAll($metadata_collection->getSelect());
        foreach ($rows as $row) {
            $attr_ids[] = $row['attribute_id'];
        }

        if (count($attr_ids) > 0) {
            $condition = $this->addAttrIdFilter($attr_ids);
            if ($condition) {
                $collection = Mage::getResourceModel('eav/entity_attribute_collection')
                        ->setEntityTypeFilter(Mage::getModel('eav/entity')->setType('customer')->getTypeId())
                        ->addFieldToFilter('main_table.attribute_id', $condition);

                $collection->getSelect()->join(array('attributemetada_table' => Mage::getModel('core/resource')->getTableName('customerattribute/attributemetada')), 'attributemetada_table.attribute_id = main_table.attribute_id', array(
                    'attributemetada_table.is_body_shape',
                    'attributemetada_table.sort_order'
                        )
                );
            }
        }

        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * Add collection filters by identifiers
     *
     * @param mixed $attributeId
     * @param boolean $exclude
     * @return mixed
     */
    public function addAttrIdFilter($attributeId, $exclude = false) {
        if (empty($attributeId)) {
            return false;
        }

        if (is_array($attributeId)) {
            if (!empty($attributeId)) {
                if ($exclude) {
                    $condition = array('nin' => $attributeId);
                } else {
                    $condition = array('in' => $attributeId);
                }
            } else {
                $condition = '';
            }
        } else {
            if ($exclude) {
                $condition = array('neq' => $attributeId);
            } else {
                $condition = $attributeId;
            }
        }

        return $condition;
    }

    protected function _prepareColumns() {
        $this->addColumn('attribute_code', array(
            'header' => Mage::helper('catalog')->__('Attribute Code'),
            'sortable' => true,
            'index' => 'attribute_code'
        ));

        $this->addColumn('frontend_label', array(
            'header' => Mage::helper('catalog')->__('Attribute Label'),
            'sortable' => true,
            'index' => 'frontend_label'
        ));

        $this->addColumn('sort_order', array(
            'header' => Mage::helper('catalog')->__('Sort Order'),
            'sortable' => true,
            'filter_index' => 'attributemetada_table.sort_order',
            'index' => 'sort_order'
        ));
        
        $this->addColumn('is_body_shape', array(
            'header' => Mage::helper('catalog')->__('Is Body Shape'),
            'sortable' => true,
            'filter_index' => 'attributemetada_table.is_body_shape',
            'index' => 'is_body_shape',
            'type' => 'options',
            'options' => array(
                '1' => Mage::helper('customer')->__('Yes'),
                '0' => Mage::helper('customer')->__('No'),
            ),
            'align' => 'center',
        ));

        $this->addColumn('is_required', array(
            'header' => Mage::helper('catalog')->__('Required'),
            'sortable' => true,
            'index' => 'is_required',
            'type' => 'options',
            'options' => array(
                '1' => Mage::helper('customer')->__('Yes'),
                '0' => Mage::helper('customer')->__('No'),
            ),
            'align' => 'center',
        ));

        $this->addColumn('is_unique', array(
            'header' => Mage::helper('catalog')->__('Is Unique'),
            'sortable' => true,
            'index' => 'is_unique',
            'type' => 'options',
            'options' => array(
                '1' => Mage::helper('customer')->__('Yes'),
                '0' => Mage::helper('customer')->__('No'),
            ),
            'align' => 'center',
        ));

        $this->addColumn('is_user_defined', array(
            'header' => Mage::helper('catalog')->__('System'),
            'sortable' => true,
            'index' => 'is_user_defined',
            'type' => 'options',
            'align' => 'center',
            'options' => array(
                '0' => Mage::helper('catalog')->__('Yes'), // intended reverted use
                '1' => Mage::helper('catalog')->__('No'), // intended reverted use
            ),
        ));


        $this->addExportType('*/*/exportCsv', Mage::helper('customerattribute')->__('CSV'));
        $this->addExportType('*/*/exportXml', Mage::helper('customerattribute')->__('XML'));

        return parent::_prepareColumns();
    }

    public function addNewButton() {
        return $this->getButtonHtml(
                        Mage::helper('customerattribute')->__('New Attribute'), //label
                        "setLocation('" . $this->getUrl('*/*/new') . "')", //url
                        "scalable add" //classe css
        );
    }

    public function getRowUrl($row) {
        return $this->getUrl('*/*/edit', array('attribute_id' => $row->getAttributeId()));
    }

}

?>