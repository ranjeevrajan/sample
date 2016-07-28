<?php

$installer = $this;

$installer->startSetup();

$installer->run("

-- DROP TABLE IF EXISTS {$this->getTable('meetlive')};
CREATE TABLE {$this->getTable('meetlive')} (
  `meetlive_id` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `email` varchar(255) NOT NULL default '',
  `telephone` varchar(20) NOT NULL default '',
  `nearest_city` varchar(30) NOT NULL default '',
  `suitable_time` varchar(30) NOT NULL default '',
  `message` text NOT NULL default '',
  `page` varchar(20) NOT NULL default '',
  `status` smallint(6) NOT NULL default '0',
  `created_time` datetime NULL,
  `update_time` datetime NULL,
  PRIMARY KEY (`meetlive_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ");

$installer->endSetup();