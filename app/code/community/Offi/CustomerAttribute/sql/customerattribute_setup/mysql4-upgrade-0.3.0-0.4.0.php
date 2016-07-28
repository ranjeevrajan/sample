<?php
/**
 * Magento Customization
 * @Author : Abdullah
 *
 */

$installer = $this;
$installer->startSetup();

//Add sort order
$installer->run("
ALTER TABLE {$this->getTable('customer_arrtibute_metadata')}
    ADD COLUMN `is_body_shape` tinyint NOT NULL default 0,
    ADD COLUMN `sort_order` int(10) NOT NULL default 0
");

$installer->endSetup();