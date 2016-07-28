<?php
/**
 * @version   1.0 14.08.2012
 * @author    TonyEcommerce http://www.TonyEcommerce.com <support@TonyEcommerce.com>
 * @copyright Copyright (c) 2012 TonyEcommerce
 */
$installer = $this;
$setup = new Mage_Eav_Model_Entity_Setup('core_setup');
$installer->startSetup();
/**
 * Adding Different Attributes
*/

// adding attribute group
$setup->addAttributeGroup('catalog_product', 'Default', 'Video', 1000);

// the attribute added will be displayed under the group/tab Special Attributes in product edit page
$setup->addAttribute('catalog_product', 'videobox', array(
    'group'         => 'Video',
    'input'         => 'textarea',
    'type'          => 'text',
    'label'         => 'Video',
    'note'          => 'Video in the tab "Video Box" </br>NOTE! To correct responsive view of your site you should place your video as iframe in tags
    <xmp><div class="embed-container"><iframe>...</iframe></div></xmp>',
    'backend'       => '',
    'visible'       => 1,
    'required'      => 0,
    'user_defined' => 1,
    'searchable' => 0,
    'filterable' => 0,
    'comparable'    => 0,
    'visible_on_front' => 1,
    'visible_in_advanced_search'  => 0,
    'is_html_allowed_on_front' => 0,
    'global'        => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
));

$installer->endSetup();



