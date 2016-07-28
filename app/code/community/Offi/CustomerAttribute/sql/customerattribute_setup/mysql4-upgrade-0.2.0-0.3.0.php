<?php
/**
 * Magento Customization
 * @Author : Abdullah
 *
 */

$installer = $this;
$installer->startSetup();

//add table to store discription locale wise
$installer->run("
    -- DROP TABLE IF EXISTS {$this->getTable('customerattribute/descriptions')};
    CREATE TABLE `{$installer->getTable('customerattribute/descriptions')}` (
        `description_label_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
        `attribute_id` smallint(5) unsigned NOT NULL DEFAULT '0',
        `store_id` smallint(5) unsigned NOT NULL DEFAULT '0',
        `value` LONGTEXT NOT NULL DEFAULT '',
        PRIMARY KEY (`description_label_id`),
        KEY `IDX_DESCRIPTIONS_LABEL_ATTRIBUTE` (`attribute_id`),
        KEY `IDX_DESCRIPTIONS_LABEL_STORE` (`store_id`),
        KEY `IDX_DESCRIPTIONS_LABEL_ATTRIBUTE_STORE` (`attribute_id`, `store_id`),
        CONSTRAINT `FK_DESCRIPTIONS_LABEL_ATTRIBUTE` FOREIGN KEY (`attribute_id`) REFERENCES `{$installer->getTable('eav/attribute')}` (`attribute_id`) ON DELETE CASCADE ON UPDATE CASCADE,
        CONSTRAINT `FK_DESCRIPTIONS_LABEL_STORE` FOREIGN KEY (`store_id`) REFERENCES `{$installer->getTable('core/store')}` (`store_id`) ON DELETE CASCADE ON UPDATE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");

//Change description field datatype
$installer->run("
ALTER TABLE `{$this->getTable('customer_arrtibute_metadata')}`
    MODIFY COLUMN `description` LONGTEXT NOT NULL default ''
");

$installer->endSetup();