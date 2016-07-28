<?php

$installer = $this;
$installer->startSetup();


$installer->run("

-- DROP TABLE IF EXISTS {$this->getTable('customer_arrtibute_metadata')};
CREATE TABLE {$this->getTable('customer_arrtibute_metadata')} (
  `metadata_id` int(11) unsigned NOT NULL auto_increment,
  `attribute_id` int(11) unsigned NOT NULL default 0,
  `short_description` varchar(255) NOT NULL default '',
  `description` varchar(255) NOT NULL default '',
  `image` varchar(255) NOT NULL default '',
  `created_time` datetime NULL,
  `update_time` datetime NULL,
  PRIMARY KEY (`metadata_id`),
  CONSTRAINT `FK_CUSTOMER_ATTRIBUTE_METADATA` FOREIGN KEY (`attribute_id`) REFERENCES `{$installer->getTable('eav_attribute')}` (`attribute_id`) ON DELETE CASCADE ON UPDATE CASCADE  
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

$installer->endSetup();