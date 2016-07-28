<?php

$installer = $this;

$installer->startSetup();

$entityTypeId     = $installer->getEntityTypeId('catalog_category');
$attributeSetId   = $installer->getDefaultAttributeSetId($entityTypeId);

$groups = array(
    'bodymeasurement'   => array(
        'name'  => 'Body Measurement',
        'sort'  => 100,
        'id'    => null
    )
);

foreach ($groups as $k => $groupProp) {
    $installer->addAttributeGroup($entityTypeId, $attributeSetId, $groupProp['name'], $groupProp['sort']);
    $groups[$k]['id'] = $installer->getAttributeGroupId($entityTypeId, $attributeSetId, $groupProp['name']);
}

//Add attribute
$installer->addAttribute('catalog_category', 'is_popup_open',  array(
    'type'     => 'int',
    'label'    => 'Should open in popup',
    'input'    => 'select',
    'source'   => 'eav/entity_attribute_source_boolean',
    'global'   => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
    'required' => false,
    'default'  => 1
));


//update attributes group and sort
$attributes = array(
    'is_popup_open' => array(
        'group' => 'bodymeasurement',
        'sort'  => 10
    )
);

//Add attribute to group
foreach ($attributes as $attributeCode => $attributeProp){
    $installer->addAttributeToGroup(
        $entityTypeId,
        $attributeSetId,
        $groups[$attributeProp['group']]['id'],
        $attributeCode,
        $attributeProp['sort']
    );
}

$installer->endSetup();                                                                    